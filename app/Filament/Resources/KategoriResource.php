<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Kategori;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\KategoriResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\KategoriResource\RelationManagers;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;

class KategoriResource extends Resource
{
    protected static ?string $model = Kategori::class;

    protected static ?string $navigationGroup = 'Kategori';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    TextInput::make('nama_kategori')
                        ->label('Nama kategori')
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state)))
                        ->required(),
                    TextInput::make('slug')
                        ->label('Slug')
                        ->readOnly()
                        ->unique(Kategori::class, 'slug', ignoreRecord: true)
                        ->required()
                ])
                    ->columnSpan(1),
                Section::make([
                    SpatieMediaLibraryFileUpload::make('foto_kategori')
                        ->label('Gambar atau desain (80x80)')
                        ->disk('gambar')
                        ->collection('foto_kategori')
                        ->required()
                ])
                    ->columnSpan(3)
            ])
            ->columns(4);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_kategori')
                    ->label('Nama Kategori'),
                TextColumn::make('slug')
                    ->label('Slug'),
                SpatieMediaLibraryImageColumn::make('foto_kategori')
                    ->collection('foto_kategori')
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
            'index' => Pages\ListKategoris::route('/'),
            'create' => Pages\CreateKategori::route('/create'),
            'edit' => Pages\EditKategori::route('/{record}/edit'),
        ];
    }
}
