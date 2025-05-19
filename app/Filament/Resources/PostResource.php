<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Post;
use App\Models\Tags;
use Filament\Tables;
use App\Models\Kategori;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
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
                        SpatieMediaLibraryFileUpload::make('post_image')
                            ->collection('post_image')
                            ->image()
                            ->nullable()
                            ->disk('posts')
                            ->rules(['mimes:jpeg,png,gif', 'max:5000'])
                            ->imagePreviewHeight('250')
                            // ->imageResizeTargetWidth('1200')
                            // ->imageResizeTargetHeight('800')
                            ->conversion('webp')
                            ->validationMessages([
                                'mimes' => 'Format file harus JPEG, PNG, atau GIF',
                                'max' => 'Ukuran file maksimum 2MB',
                            ]),
                    ]),
                Section::make('SEO')
                    ->icon('heroicon-o-globe-alt')
                    ->schema([
                        TextInput::make('meta_title')
                            ->maxLength(60)
                            ->nullable(),
                        Textarea::make('meta_description')
                            ->maxLength(160)
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
