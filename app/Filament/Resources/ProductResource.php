<?php

namespace App\Filament\Resources;

use App\Models\Tag;
use Filament\Forms;
use App\Models\Tags;
use Filament\Tables;
use App\Models\Product;
use App\Models\Kategori;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use League\Uri\Idna\Option;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ToggleButtons;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationGroup = 'Shop';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Nama & Slug')
                    ->schema([
                        TextInput::make('nama_product')
                            ->label('Judul')
                            ->live(onBlur: true)
                            ->maxLength(255)
                            ->afterStateUpdated(fn(string $operation, $state, Forms\Set $set) => $set('slug', Str::slug($state)))
                            ->required(),
                        TextInput::make('slug')
                            ->disabled()
                            ->dehydrated()
                            ->required()
                            ->maxLength(255)
                            ->unique(Product::class, 'slug', ignoreRecord: true),
                        TextInput::make('brand')
                            ->label('Brand'),
                        TextInput::make('bpom')
                            ->label('No. Bpom'),
                    ])
                    ->columns(2),
                Section::make('Stok')
                    ->schema([
                        TextInput::make('stok')
                            ->label('Stok'),
                        TextInput::make('terjual')
                            ->label('Terjual'),
                    ])
                    ->columns(2),
                Section::make('Kategori & Harga')
                    ->schema([
                        Select::make('id_kategori')
                            ->label('Kategori')
                            ->options(Kategori::all()->pluck('nama_kategori', 'id_kategori'))
                            ->searchable()
                            ->required(),
                        TextInput::make('diskon')
                            ->label('Diskon %')
                            ->numeric()
                            ->required(),
                        TextInput::make('harga')
                            ->label('Harga Asli')
                            ->required(),
                    ])
                    ->columns(3),
                Section::make('Foto & Tags')
                    ->schema([
                        FileUpload::make('foto_product')
                            ->label('Foto')
                            ->image()
                            ->multiple()
                            ->directory('/image/product')
                            ->required(),

                        Select::make('tags')
                            ->label('Tags')
                            ->options(Tags::all()->pluck('nama_tag', 'id_tag'))
                            ->multiple()
                            ->relationship('tags', 'nama_tag')
                            ->preload()
                            ->required(),
                    ])
                    ->columns(2),
                Section::make('Deskripsi & Keyword')
                    ->schema([
                        RichEditor::make('ringkasan')
                            ->label('Ringkasan Max 300 Character')
                            ->maxLength(300),
                        RichEditor::make('keyword')
                            ->label('Keyword'),
                        RichEditor::make('deskripsi')
                            ->label('Deskripsi'),
                    ]),
                Section::make('Label')
                    ->schema([
                        Select::make('label')
                            ->options([
                                '1' => 'Best Price',
                                '0' => 'Normal Price'
                            ])
                    ])
                    ->columnSpan(1)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_product')
                    ->label('Judul'),
                TextColumn::make('slug')
                    ->label('Slug'),
                TextColumn::make('diskon')
                    ->label('Diskon')
                    ->formatStateUsing(fn($state) => $state . '%'),
                TextColumn::make('harga')
                    ->label('Harga')
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.')),
                TextColumn::make('kategori.nama_kategori')
                    ->label('Kategori'),
                ImageColumn::make('foto_product')
                    ->circular(),
                TextColumn::make('stok')
                    ->label('Stok')
                    ->formatStateUsing(fn($state) => $state . 'Pcs'),
                TextColumn::make('terjual')
                    ->label('Terjual')
                    ->formatStateUsing(fn($state) => $state . 'Pcs'),
                TextColumn::make('label')
                    ->label('Label')
                    ->formatStateUsing(
                        fn($record) => ($record->label) ? 'Best Price' : 'Normal Price'
                    ),
                TextColumn::make('bpom')
                    ->label('No. BPOM'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
