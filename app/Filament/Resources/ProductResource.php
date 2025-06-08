<?php

namespace App\Filament\Resources;

use Gemini;
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
use Gemini\Data\SafetySetting;
use Gemini\Enums\HarmCategory;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Facades\Log;
use Filament\Forms\Components\Split;
use Gemini\Enums\HarmBlockThreshold;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\Actions\Action;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Resources\ProductResource\RelationManagers;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationGroup = 'Shop';

    protected static ?int $navigationSort = 0;

    protected static ?string $navigationIcon = 'heroicon-o-gift';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('✨ AI Product Generator')
                    ->icon('heroicon-o-sparkles')
                    ->collapsible()
                    ->schema([
                        TextInput::make('ai_product_prompt')
                            ->label('Nama Produk atau Topik')
                            ->placeholder('Contoh: Titan Gel Gold Original')
                            ->helperText('Masukkan nama produk, AI akan membuat deskripsi, manfaat, dll.')
                            ->dehydrated(false)
                            ->suffixAction(
                                Action::make('generateProductContent')
                                    ->label('Generate Deskripsi Produk')
                                    ->icon('heroicon-o-bolt')
                                    ->action(function ($set, $get) {
                                        $topic = $get('ai_product_prompt');
                                        if (empty($topic)) {
                                            Notification::make()->title('Topik tidak boleh kosong')->warning()->send();
                                            return;
                                        }

                                        Notification::make()->title('Sedang membuat deskripsi produk...')->info()->send();
                                        $aiResponse = self::callProductGeneratorApi($topic);

                                        if (empty($aiResponse)) {
                                            Notification::make()->title('AI Gagal Merespons')->danger()->send();
                                            return;
                                        }

                                        // Mengisi field-field relevan
                                        $set('nama_product', $aiResponse['nama_product'] ?? '');
                                        $set('slug', Str::slug($aiResponse['nama_product'] ?? ''));
                                        $set('brand', $aiResponse['brand'] ?? '');
                                        $set('ringkasan', $aiResponse['ringkasan'] ?? '');
                                        $set('deskripsi', $aiResponse['deskripsi'] ?? '');
                                        $set('keyword', $aiResponse['keyword'] ?? '');
                                        $set('ingredient', $aiResponse['ingredient'] ?? '');
                                        $set('manfaat', $aiResponse['manfaat'] ?? '');

                                        // Logika untuk mengisi Kategori
                                        $suggestedCategoryName = $aiResponse['suggested_category'] ?? null;
                                        if ($suggestedCategoryName) {
                                            $category = Kategori::where('nama_kategori', 'like', '%' . $suggestedCategoryName . '%')->first();
                                            if ($category) {
                                                $set('id_kategori', $category->id_kategori);
                                            }
                                        }

                                        // Logika untuk mengisi Tags
                                        $suggestedTags = $aiResponse['suggested_tags'] ?? [];
                                        if (!empty($suggestedTags) && is_array($suggestedTags)) {
                                            $tagIds = [];
                                            foreach ($suggestedTags as $tagName) {
                                                $tag = Tags::firstOrCreate(
                                                    ['slug' => Str::slug($tagName)],
                                                    ['nama_tag' => trim($tagName)]
                                                );
                                                $tagIds[] = $tag->id;
                                            }
                                            $set('tags', $tagIds);
                                        }
                                        Notification::make()->title('Deskripsi produk berhasil dibuat!')->success()->send();
                                    })
                            )
                    ]),
                Section::make('Nama & Slug')
                    ->schema([
                        TextInput::make('nama_product')
                            ->label('Judul')
                            ->live(onBlur: true)
                            ->maxLength(255)
                            ->afterStateUpdated(fn(string $operation, $state, Forms\Set $set) => $set('slug', Str::slug($state)))
                            ->required()
                            ->unique(Product::class, 'nama_product', ignoreRecord: true),
                        TextInput::make('slug')
                            ->disabled()
                            ->dehydrated()
                            ->required()
                            ->maxLength(255)
                            ->unique(Product::class, 'slug', ignoreRecord: true),
                        TextInput::make('brand')
                            ->label('Brand')
                            ->required(),
                        TextInput::make('bpom')
                            ->label('No. Bpom')
                            ->required()
                            ->unique(Product::class, 'bpom', ignoreRecord: true),
                        TextInput::make('stok')
                            ->label('Stok')
                            ->required(),
                        TextInput::make('terjual')
                            ->label('Terjual')
                            ->required(),
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
                    ->columnSpan(1)
                    ->columns(1),
                Section::make('Foto & Tags')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('foto_product')
                            ->label('Foto atau desain (600x600)')
                            ->disk('foto_product')
                            ->collection('foto_product')
                            ->conversion('webp')
                            ->image()
                            ->imageEditor()
                            ->multiple()
                            ->required(),
                        Section::make([
                            RichEditor::make('ringkasan')
                                ->label('Ringkasan Max 300 Character')
                                ->maxLength(5000)
                                ->columnSpan(3),
                            RichEditor::make('deskripsi')
                                ->label('Description')
                                ->columnSpan(3),
                            Textarea::make('keyword')
                                ->label('meta_keyword')
                                ->columnSpan(3),
                            RichEditor::make('ingredient')
                                ->label('Ingredient (Pisah dengan ",")')
                                ->columnSpan(2),
                            RichEditor::make('manfaat')
                                ->label('Manfaat (Berikan Poin)')
                                ->columnSpan(2),
                            TextInput::make('size')
                                ->label('Size "Sertakan gramasi"')
                                ->columnSpan(1),
                            Select::make('tags')
                                ->label('Tags')
                                ->options(Tags::all()->pluck('nama_tag', 'id_tag'))
                                ->multiple()
                                ->relationship('tags', 'nama_tag')
                                ->preload()
                                ->required()
                                ->createOptionForm([
                                    TextInput::make('nama_tag')
                                        ->label('Nama Tag')
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state)))
                                        ->required(),
                                    TextInput::make('slug')
                                        ->label('Slug')
                                        ->readOnly()
                                        ->unique(Tags::class, 'slug', ignoreRecord: true)
                                ])
                                ->columnSpan(2),
                            Select::make('label')
                                ->preload()
                                ->searchable()
                                ->options([
                                    '1' => 'Best Price',
                                    '0' => 'Normal Price'
                                ])
                                ->columnSpan(1)
                        ])
                            ->columns(3)
                    ])
                    ->columnSpan(3)
                    ->columns(1)
            ])
            ->columns(4);
    }
    public static function callProductGeneratorApi(string $topic): array
    {
        $kategoriList = Kategori::pluck('nama_kategori')->implode(', ');
        $tagList = Tags::pluck('nama_tag')->implode(', ');

        $prompt = "Anda adalah seorang copywriter ahli untuk produk e-commerce, khususnya produk kesehatan dan keintiman pria & wanita.
        Berdasarkan nama produk berikut: '{$topic}', buatkan deskripsi lengkap untuk halaman produk.

        Aturan Penting:
        - Gunakan gaya bahasa yang persuasif, informatif, tapi tetap profesional dan tidak vulgar.
        - Fokus pada manfaat dan keunggulan produk.
        - Hasil HARUS dalam format JSON yang valid, dengan struktur persis seperti ini:
        {
            \"nama_product\": \"(Nama produk resmi, sedikit dipercantik jika perlu)\",
            \"brand\": \"(Tebak nama brand dari nama produk, jika tidak tahu, isi dengan nama produknya)\",
            \"ringkasan\": \"(Ringkasan singkat produk dalam 1-2 kalimat yang menarik)\",
            \"deskripsi\": \"(Deskripsi produk lengkap dalam format HTML, jelaskan apa itu produk, untuk siapa, dan kenapa orang harus membelinya. Gunakan paragraf dan bold.)\",
            \"manfaat\": \"(Manfaat utama produk dalam format HTML, gunakan list <ul><li>...</li></ul>)\",
            \"ingredient\": \"(Bahan-bahan utama dalam format HTML, gunakan list <ul><li>...</li></ul>. Jika tidak tahu pasti, sebutkan bahan-bahan herbal umum yang relevan dan aman untuk kategori produk ini.)\",
            \"keyword\": \"(5-7 keyword relevan untuk SEO, pisahkan dengan koma)\",
            \"suggested_category\": \"(Pilih SATU kategori yang paling cocok dari daftar ini: {$kategoriList})\",
            \"suggested_tags\": [\"(Pilih 3-5 tag yang paling cocok dari daftar ini: {$tagList})\"]
        }";

        try {
            $apiKey = getenv('GEMINI_API_KEY');
            $client = Gemini::client($apiKey);
            $model = $client->generativeModel('gemini-2.5-flash-preview-05-20');
            $result = $model->generateContent($prompt);

            $jsonResponse = $result->text();
            $cleanedJson = trim($jsonResponse, " \n\r\t\v\0`");
            if (Str::startsWith($cleanedJson, 'json')) {
                $cleanedJson = Str::after($cleanedJson, 'json');
            }
            $data = json_decode($cleanedJson, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('Gemini API Response - Invalid JSON: ' . json_last_error_msg(), ['response' => $jsonResponse]);
                return [];
            }
            return $data;

        } catch (\Exception $e) {
            Log::error('Gemini API call failed: ' . $e->getMessage());
            return [];
        }
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_product')
                    ->label('Judul')
                    ->searchable()
                    ->limit(20),
                TextColumn::make('slug')
                    ->label('Slug')
                    ->limit(20),
                TextColumn::make('diskon')
                    ->label('Diskon')
                    ->formatStateUsing(fn($state) => $state . '%'),
                TextColumn::make('harga')
                    ->label('Harga')
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.')),
                TextColumn::make('kategori.nama_kategori')
                    ->label('Kategori'),
                SpatieMediaLibraryImageColumn::make('foto_product')
                    ->collection('foto_product')
                    ->stacked()
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
