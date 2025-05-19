<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\City;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Tables;
use App\Models\Order;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use App\Filament\Resources\OrderResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OrderResource\RelationManagers;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationGroup = 'Shop';

    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Pesanan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Pelanggan')
                    ->description('Masukkan detail pelanggan untuk pesanan ini.')
                    ->icon('heroicon-o-user')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('user_id')
                                    ->label('Pelanggan')
                                    ->relationship('user', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->native(false)
                                    ->helperText('Pilih pelanggan dari daftar pengguna.'),
                                TextInput::make('customer_name')
                                    ->label('Nama Pelanggan')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Masukkan nama lengkap'),
                                TextInput::make('customer_email')
                                    ->label('Email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('contoh@email.com'),
                                TextInput::make('customer_phone')
                                    ->label('Telepon')
                                    ->tel()
                                    ->required()
                                    ->maxLength(20)
                                    ->placeholder('+62 123 456 7890'),
                            ]),
                    ]),
                Section::make('Alamat Pengiriman')
                    ->description('Lengkapi informasi alamat pengiriman.')
                    ->icon('heroicon-o-map-pin')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('province_id')
                                    ->label('Provinsi')
                                    ->relationship('province', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->native(false)
                                    ->reactive()
                                    ->afterStateUpdated(function (callable $set) {
                                        $set('city_id', null);
                                    })
                                    ->helperText('Pilih provinsi terlebih dahulu.'),
                                Select::make('city_id')
                                    ->label('Kabupaten/Kota')
                                    ->options(function (callable $get) {
                                        $provinceId = $get('province_id');
                                        if (!$provinceId) {
                                            return [];
                                        }
                                        return City::where('province_id', $provinceId)
                                            ->pluck('name', 'city_id')
                                            ->toArray();
                                    })
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->native(false)
                                    ->reactive()
                                    ->helperText('Pilih kota sesuai provinsi.'),
                                TextInput::make('district')
                                    ->label('Kecamatan')
                                    ->maxLength(255)
                                    ->placeholder('Masukkan nama kecamatan'),
                                TextInput::make('postal_code')
                                    ->label('Kode POS')
                                    ->maxLength(10)
                                    ->placeholder('Masukkan kode pos'),
                                Textarea::make('customer_address')
                                    ->label('Alamat')
                                    ->required()
                                    ->rows(4)
                                    ->maxLength(500)
                                    ->placeholder('Masukkan alamat lengkap')
                                    ->columnSpan(2),
                            ]),
                    ]),
                Section::make('Detail Pesanan')
                    ->description('Masukkan informasi produk, pengiriman, dan pembayaran.')
                    ->icon('heroicon-o-shopping-bag')
                    ->schema([
                        Repeater::make('order_item')
                            ->label('Produk')
                            ->relationship('order_item')
                            ->schema([
                                Select::make('id_product')
                                    ->label('Produk')
                                    ->relationship('product', 'nama_product') // Ganti 'product_name' dengan kolom yang benar
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->native(false)
                                    ->reactive()
                                    ->afterStateUpdated(function (callable $set, $state) {
                                        $product = Product::find($state);
                                        $set('harga', $product ? $product->harga : 0);
                                    }),
                                TextInput::make('quantity')
                                    ->label('Jumlah')
                                    ->numeric()
                                    ->required()
                                    ->minValue(1)
                                    ->default(1)
                                    ->live()
                                    ->reactive()
                                    ->afterStateUpdated(function (callable $set, $state, $get) {
                                        $harga = $get('harga');
                                        $set('subtotal', $state * $harga);
                                    }),
                                TextInput::make('harga')
                                    ->label('Harga Satuan')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->minValue(0)
                                    ->required()
                                    ->disabled()
                                    ->dehydrated(false),
                                TextInput::make('subtotal')
                                    ->label('Subtotal')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->minValue(0)
                                    ->required()
                                    ->disabled()
                                    ->dehydrated(false),
                            ])
                            ->columns(4)
                            ->columnSpan(2)
                            ->addActionLabel('Tambah Produk')
                            // ->deleteActionLabel('Hapus Produk')
                            ->required()
                            ->helperText('Tambahkan produk yang dipesan.'),
                        Grid::make(2)
                            ->schema([
                                TextInput::make('shipping_courier')
                                    ->label('Kurir')
                                    ->maxLength(255)
                                    ->placeholder('JNE, J&T, dll.'),
                                TextInput::make('shipping_service')
                                    ->label('Layanan Pengiriman')
                                    ->maxLength(255)
                                    ->placeholder('Reguler, Express, dll.'),
                                TextInput::make('payment_method')
                                    ->label('Metode Pembayaran')
                                    ->maxLength(255)
                                    ->placeholder('Bank Transfer, COD, dll.'),
                                Select::make('status')
                                    ->label('Status')
                                    ->options([
                                        'pending' => 'Pending',
                                        'shipped' => 'Shipped',
                                        'delivered' => 'Delivered',
                                    ])
                                    ->required()
                                    ->native(false)
                                    ->default('pending')
                                    ->helperText('Pilih status pesanan.'),
                                TextInput::make('shipping_cost')
                                    ->label('Ongkos Kirim')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->minValue(0)
                                    ->placeholder('0')
                                    ->reactive()
                                    ->afterStateUpdated(function (callable $set, $state, $get) {
                                        $items = $get('order_item') ?? [];
                                        $subtotal = collect($items)->sum('subtotal');
                                        $set('subtotal', $subtotal);
                                        $set('total', $subtotal + ($state ?? 0));
                                    }),
                                TextInput::make('subtotal')
                                    ->label('Subtotal Belanja')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->minValue(0)
                                    ->disabled()
                                    ->dehydrated(false),
                                TextInput::make('total')
                                    ->label('Total')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->minValue(0)
                                    ->disabled()
                                    ->dehydrated(false),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('customer_email')
                    ->label('Email')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('customer_phone')
                    ->label('Phone') // Diperbaiki dari 'Email'
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('province.name')
                    ->label('Provinsi')
                    ->toggleable()
                    ->sortable()
                    ->default('Tidak Diketahui'),
                TextColumn::make('city_id')
                    ->label('Nama Kota')
                    ->formatStateUsing(function ($state, $record) {
                        return City::where('province_id', $record->province_id)
                            ->where('city_id', $record->city_id)
                            ->value('name') ?? 'Tidak Diketahui';
                    }),
                TextColumn::make('shipping_courier')
                    ->label('Kurir')
                    ->toggleable(),
                TextColumn::make('shipping_service')
                    ->label('Paket')
                    ->toggleable(),
                TextColumn::make('payment_method')
                    ->label('Payment')
                    ->toggleable(),
                TextColumn::make('district')
                    ->label('Kecamatan')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('postal_code')
                    ->label('Kode POS')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('shipping_cost')
                    ->label('Ongkir')
                    ->money('idr')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('subtotal')
                    ->label('Belanja')
                    ->money('idr')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('total')
                    ->label('Total')
                    ->money('idr')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->icon(
                        fn(string $state): string => match ($state) {
                            'pending' => 'heroicon-o-arrow-path',
                            'shipped' => 'heroicon-o-truck',
                            'delivered' => 'heroicon-o-check-circle',
                        }
                    )
                    ->color(
                        fn(string $state): string => match ($state) {
                            'pending' => 'warning',
                            'shipped' => 'info',
                            'delivered' => 'success',
                        }
                    ),

            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make('Lihat Item')
                        ->label('Item Pesanan')
                        ->icon('heroicon-o-shopping-bag'),
                    Action::make('Ubah Status')
                        ->icon('heroicon-o-wrench')
                        ->form([
                            Select::make('status')
                                ->label('Ubah Status')
                                ->options([
                                    'pending' => 'Pending',
                                    'shipped' => 'Shipped',
                                    'delivered' => 'Delivered'
                                ])
                                ->native(false)
                                ->required()
                        ])
                        ->action(function (array $data, Order $record): void {
                            $record->status = $data['status'];
                            $record->save();
                        }),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                RepeatableEntry::make('order_item')
                    ->schema([
                        TextEntry::make('product.nama_product')
                            ->label('Nama Produk'),
                        TextEntry::make('quantity')
                            ->label('QTY'),
                    ])
                    ->columns(2)
            ])
            ->columns(1);
    }
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
