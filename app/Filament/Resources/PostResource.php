<?php

namespace App\Filament\Resources;

use Gemini;
use Filament\Forms;
use App\Models\Post;
use App\Models\Tags;
use Filament\Tables;
use App\Models\Kategori;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Gemini\Enums\HarmBlockThreshold;
use Illuminate\Support\Str;
use Gemini\Data\SafetySetting;
use Gemini\Enums\HarmCategory;
use Gemini\Enums\BlockThreshold;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Log;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Actions\Action;
use App\Filament\Resources\PostResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PostResource\RelationManagers;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // ==========================================================
                // BAGIAN AI GENERATOR - DITAMBAHKAN DI SINI
                // ==========================================================
                Section::make('✨ AI Content Generator')
                    ->icon('heroicon-o-sparkles')
                    ->collapsible()
                    ->schema([
                        TextInput::make('ai_prompt')
                            ->label('Topik atau Ide Artikel')
                            ->dehydrated(false)
                            ->placeholder('Contoh: Manfaat Titan Gel Gold untuk pria')
                            ->helperText('Masukkan topik, lalu klik ikon petir di sebelah kanan untuk membuat konten.')
                            // ==========================================================
                            // PERBAIKAN DI SINI: Action ditempelkan sebagai suffixAction
                            // ==========================================================
                            ->suffixAction(
                                Action::make('generateContent')
                                    ->label('Generate Konten dengan AI')
                                    ->icon('heroicon-o-bolt')
                                    ->action(function ($set, $get) {
                                        $topic = $get('ai_prompt');
                                        if (empty($topic)) {
                                            // Anda bisa tambahkan notifikasi di sini jika mau
                                            return;
                                        }

                                        // Untuk simulasi, kita gunakan data contoh:
                                        $aiResponse = self::callGeminiApi($topic);
                                        if (empty($aiResponse)) {
                                            // Di sini Anda bisa menambahkan notifikasi error ke pengguna
                                            Notification::make()->title('AI Gagal Merespons')->danger()->send();
                                            return;
                                        }
                                        // Mengisi semua field form dengan respons dari AI
                                        $set('title', $aiResponse['title'] ?? '');
                                        $set('slug', Str::slug($aiResponse['title'] ?? '')); // Gunakan juga di sini
                                        $set('content', $aiResponse['content'] ?? 'Konten tidak berhasil digenerate. Silakan coba lagi.');
                                        $set('image_prompt', $aiResponse['image_prompt'] ?? 'AI tidak memberikan saran gambar.');
                                        $set('meta_title', $aiResponse['meta_title'] ?? '');
                                        $set('meta_description', $aiResponse['meta_description'] ?? '');
                                        $set('meta_keywords', $aiResponse['meta_keywords'] ?? '');

                                        // Logika untuk mengisi Kategori berdasarkan nama
                                        $suggestedCategoryName = $aiResponse['suggested_category'];
                                        $category = Kategori::where('nama_kategori', 'like', '%' . $suggestedCategoryName . '%')->first();
                                        if ($category) {
                                            $set('kategori_id', $category->id_kategori);
                                        }

                                        // Logika untuk mengisi Tags berdasarkan nama
                                        $suggestedTags = $aiResponse['suggested_tags'];
                                        $tagIds = [];
                                        foreach ($suggestedTags as $tagName) {
                                            $tag = Tags::firstOrCreate(
                                                ['slug' => Str::slug($tagName)],
                                                ['nama_tag' => trim($tagName)]
                                            );
                                            $tagIds[] = $tag->id;
                                        }
                                        $set('post_tags', $tagIds);
                                    })
                            )
                    ]),
                Section::make('Informasi Utama')
                    ->icon('heroicon-o-pencil')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('slug', Str::slug($state));
                            })
                            ->extraInputAttributes(['class' => 'border-gray-300 rounded-lg']),
                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(Post::class, 'slug', ignorable: fn($record) => $record)
                            ->extraInputAttributes(['class' => 'border-gray-300 rounded-lg']),
                        RichEditor::make('content')
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Section::make('Kategori dan Tags')
                    ->icon('heroicon-o-folder')
                    ->schema([
                        Select::make('kategori_id')
                            ->relationship(name: 'kategori', titleAttribute: 'nama_kategori')
                            ->options(Kategori::all()->pluck('nama_kategori', 'id_kategori'))
                            ->required()
                            ->native(false)
                            ->searchable()
                            ->createOptionForm([
                                TextInput::make('nama_kategori')
                                    ->required()
                                    ->maxLength(255)
                                    ->reactive()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        $set('slug', Str::slug($state));
                                    }),
                                TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(Kategori::class, 'slug')
                                    ->validationMessages([
                                        'unique' => 'Data sudah ada di database',
                                    ]),
                                SpatieMediaLibraryFileUpload::make('foto_kategori')
                                    ->label('Gambar atau desain (80x80)')
                                    ->disk('gambar')
                                    ->collection('foto_kategori')
                                    ->required()
                                    ->image()
                                    ->imageResizeTargetWidth('80')
                                    ->imageResizeTargetHeight('80')
                                    ->rules(['mimes:jpeg,png,gif', 'max:2048']),
                            ]),
                        Select::make('post_tags')
                            ->multiple()
                            ->relationship(name: 'tags', titleAttribute: 'nama_tag')
                            ->options(Tags::all()->pluck('nama_tag', 'id'))
                            ->preload()
                            ->searchable()
                            ->createOptionForm([
                                TextInput::make('nama_tag')
                                    ->required()
                                    ->maxLength(255)
                                    ->reactive()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        $set('slug', Str::slug($state));
                                    }),
                                TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(Tags::class, 'slug')
                                    ->validationMessages([
                                        'unique' => 'Data sudah ada di database',
                                    ]),
                            ]),
                    ])
                    ->columns(2),
                Section::make('Media')
                    ->icon('heroicon-o-photo')
                    ->schema([
                        Textarea::make('image_prompt')
                            ->label('💡 Ide Prompt Gambar dari AI')
                            ->helperText('Salin teks di bawah ini dan gunakan di layanan AI generator gambar favorit Anda.')
                            ->rows(4)
                            ->dehydrated(false),
                        SpatieMediaLibraryFileUpload::make('post_image')
                            ->collection('post_image')
                            ->image()
                            ->nullable()
                            ->disk('posts')
                            ->rules(['mimes:jpeg,png,gif', 'max:5120']) // 5 x 1024 = 5120 KB
                            ->imagePreviewHeight('250')
                            // ->imageResizeTargetWidth('1200')
                            // ->imageResizeTargetHeight('800')
                            ->conversion('webp')
                            ->validationMessages([
                                'mimes' => 'Format file harus JPEG, PNG, atau GIF',
                                'max' => 'Ukuran file maksimum 5MB', // Pesan disamakan
                            ]),

                    ]),
                Section::make('SEO')
                    ->icon('heroicon-o-globe-alt')
                    ->schema([
                        TextInput::make('meta_title')
                            ->maxLength(70)
                            ->nullable(),
                        Textarea::make('meta_description')
                            ->maxLength(180)
                            ->nullable()
                            ->rows(3),
                        TextInput::make('meta_keywords')
                            ->maxLength(255)
                            ->nullable(),
                    ])
                    ->columns(2),
                Section::make('Status')
                    ->icon('heroicon-o-light-bulb')
                    ->schema([
                        Toggle::make('is_published')
                            ->default(false)
                            ->inline(false)
                            ->label('Publikasikan'),
                    ]),
            ]);
    }
    public static function callGeminiApi(string $topic): array
    {
        $kategoriList = Kategori::pluck('nama_kategori')->implode(', ');
        // Bagian prompt tetap sama
        $prompt = "Anda adalah seorang penulis konten dan spesialis SEO yang sangat ahli untuk website berbahasa Indonesia.
    Berdasarkan topik utama berikut: '{$topic}', tolong buatkan konten artikel.
    
    Aturan Penting:
    - Gunakan Bahasa Indonesia yang natural dan menarik.
    - Konten harus orisinal dan informatif.
    - Buat struktur artikel dengan heading (h2, h3) dan paragraf.
    - Pastikan semua field SEO terisi dengan baik dan relevan.
    
    Tolong kembalikan hasilnya HANYA dalam format JSON yang valid, dengan struktur persis seperti ini:
    {
        \"title\": \"(Judul artikel yang menarik dan SEO-friendly, maksimal 70 karakter)\",
        \"content\": \"(Isi artikel lengkap dalam format HTML, minimal 300 kata. Gunakan tag <p>, <h2>, <h3>, dan <ul>)\",
        \"suggested_category\": \"(Pilih SATU... dari daftar berikut: {$kategoriList})\",
        \"suggested_tags\": [\"(3 sampai 5 tag atau keyword relevan dalam bentuk array of strings)\"],
        \"meta_title\": \"(Meta title yang dioptimalkan untuk SEO, maksimal 60 karakter)\",
        \"meta_description\": \"(Meta description yang persuasif, maksimal 160 karakter)\",
        \"meta_keywords\": \"(Kumpulan keyword relevan, dipisahkan koma)\",
        \"image_prompt\": \"(Tulis sebuah prompt gambar yang sangat deskriptif dalam Bahasa Inggris untuk AI generator gambar seperti Midjourney atau DALL-E, yang secara visual merepresentasikan isi artikel ini. Buat seolah-olah Anda adalah seorang art director profesional.)\"
    }";

        try {
            // ====================================================================
            // PERBAIKAN FINAL: Menggunakan alur yang benar sesuai dokumentasi
            // ====================================================================

            // 1. Buat client (Tetap sama)
            $apiKey = getenv('GEMINI_API_KEY');
            $client = Gemini::client($apiKey);
            $model = $client->generativeModel('gemini-2.5-flash-preview-05-20')
                ->withSafetySetting(
                    new SafetySetting(
                        category: HarmCategory::HARM_CATEGORY_HATE_SPEECH,
                        threshold: HarmBlockThreshold::BLOCK_ONLY_HIGH
                    )
                )
                ->withSafetySetting(
                    new SafetySetting(
                        category: HarmCategory::HARM_CATEGORY_HARASSMENT,
                        threshold: HarmBlockThreshold::BLOCK_ONLY_HIGH
                    )
                )
                ->withSafetySetting(
                    new SafetySetting(
                        category: HarmCategory::HARM_CATEGORY_SEXUALLY_EXPLICIT,
                        threshold: HarmBlockThreshold::BLOCK_ONLY_HIGH
                    )
                )
                ->withSafetySetting(
                    new SafetySetting(
                        category: HarmCategory::HARM_CATEGORY_DANGEROUS_CONTENT,
                        threshold: HarmBlockThreshold::BLOCK_ONLY_HIGH
                    )
                );
            // $model = $client->generativeModel('gemini-2.5-flash-preview-05-20')
            //     ->withSafetySetting($safetySettings);

            // 3. Generate konten dari variabel $model tersebut
            $result = $model->generateContent($prompt);

            // Bagian membersihkan dan decode JSON tetap sama
            $jsonResponse = $result->text();
            $cleanedJson = trim($jsonResponse, " \n\r\t\v\0`");
            if (Str::startsWith($cleanedJson, 'json')) {
                $cleanedJson = Str::after($cleanedJson, 'json');
            }
            $data = json_decode($cleanedJson, true);

            // Bagian validasi JSON tetap sama
            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('Gemini API Response - Invalid JSON: ' . json_last_error_msg());
                Log::error('Gemini Raw Response: ' . $jsonResponse);
                return [];
            }

            return $data;

        } catch (\Exception $e) {
            // Bagian menangani error tetap sama
            Log::error('Gemini API call failed: ' . $e->getMessage());
            return [];
        }
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->sortable()
                    ->searchable()
                    ->wrap(),
                TextColumn::make('kategori.nama_kategori')
                    ->sortable()
                    ->label('Kategori'),
                TextColumn::make('tags.nama_tag')
                    ->sortable()
                    ->badge()
                    ->label('Tags'),
                SpatieMediaLibraryImageColumn::make('post_image')
                    ->collection('post_image')
                    ->label('Gambar'),
                ToggleColumn::make('is_published')
                    ->label('Published'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori_id')
                    ->relationship('kategori', 'nama_kategori')
                    ->label('Kategori'),
                Tables\Filters\SelectFilter::make('tags')
                    ->multiple()
                    ->relationship('tags', 'nama_tag')
                    ->label('Tags'),
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Status Publikasi'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
