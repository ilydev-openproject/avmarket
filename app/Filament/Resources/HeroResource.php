<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroResource\Pages;
use App\Filament\Resources\HeroResource\RelationManagers;
use App\Models\Hero;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                    Select::make('cta')
                        ->options(Product::all()->pluck('nama_product', 'id'))
                        ->preload()
                        ->searchable()
                        ->required()
                ])
                    ->columnSpan(1),
                Section::make([
                    RichEditor::make('paragraph')
                        ->required(),
                    SpatieMediaLibraryFileUpload::make('foto_hero')
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
                TextColumn::make('subheader'),
                TextColumn::make('header'),
                SpatieMediaLibraryImageColumn::make('foto_hero')
                    ->label('gambar')
                    ->collection('foto_hero'),
                TextColumn::make('product.slug')
                    ->prefix('https://product/'),
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
            'index' => Pages\ListHeroes::route('/'),
            'create' => Pages\CreateHero::route('/create'),
            'edit' => Pages\EditHero::route('/{record}/edit'),
        ];
    }
}
