<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Hero;
use App\Models\Tags;
use Filament\Tables;
use App\Models\Product;
use App\Models\Kategori;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\HeroResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\HeroResource\RelationManagers;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class HeroResource extends Resource
{
    protected static ?string $model = Hero::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    TextInput::make('subheader')
                        ->required(),
                    TextInput::make('header')
                        ->required(),
                    TextInput::make('cta_text')
                        ->label('Text CTA')
                        ->required(),
                    Select::make('cta')
                        ->options([
                            'Kategori' => Kategori::pluck('nama_kategori', 'slug')->map(fn($nama) => ucfirst($nama))->toArray(),
                            'Product' => Product::pluck('nama_product', 'slug')->map(fn($nama) => ucfirst($nama))->toArray(),
                            'Tags' => Tags::pluck('nama_tag', 'slug')->map(fn($nama) => ucfirst($nama))->toArray(),
                        ])
                        ->preload()
                        ->searchable()
                        ->required()
                        ->afterStateUpdated(fn($state, $set) => $set('cta', match (true) {
                            Kategori::where('slug', $state)->exists() => 'kategori/' . $state,
                            Product::where('slug', $state)->exists() => 'product/' . $state,
                            Tags::where('slug', $state)->exists() => 'tags/' . $state,
                            default => $state
                        }))
                ])
                    ->columnSpan(1),
                Section::make([
                    RichEditor::make('paragraph')
                        ->required(),
                    SpatieMediaLibraryFileUpload::make('foto_hero')
                        ->label('Gambar atau desain hero (762x495)')
                        ->collection('foto_hero')
                        ->disk('gambar')
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
                TextColumn::make('subheader')
                    ->limit(12),
                TextColumn::make('header')
                    ->limit(30),
                SpatieMediaLibraryImageColumn::make('foto_hero')
                    ->label('gambar')
                    ->collection('foto_hero'),
                TextColumn::make('cta_text')
                    ->label('Text CTA'),
                TextColumn::make('cta')
                    ->formatStateUsing(fn($state) => $state ? config('app.url') . '/' . $state : '-')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListHeroes::route('/'),
            'create' => Pages\CreateHero::route('/create'),
            'edit' => Pages\EditHero::route('/{record}/edit'),
        ];
    }
}
