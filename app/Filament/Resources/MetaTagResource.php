<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MetaTagResource\Pages;
use App\Models\MetaTag;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Artisan;

class MetaTagResource extends Resource
{
    protected static ?string $model = MetaTag::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';

    protected static ?string $navigationLabel = 'Meta Tags';

    protected static ?string $pluralLabel = 'Meta Tags';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('url')
                    ->label('Page URL')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->prefix(url('/'))
                    ->placeholder('produk/suplemen-herbal'),
                Forms\Components\TextInput::make('title')
                    ->label('Meta Title')
                    ->maxLength(70)
                    ->helperText('Maksimal 70 karakter untuk SEO.'),
                Forms\Components\Textarea::make('description')
                    ->label('Meta Description')
                    ->rows(3)
                    ->maxLength(160)
                    ->helperText('Maksimal 160 karakter untuk SEO.'),
                Forms\Components\TextInput::make('keywords')
                    ->label('Meta Keywords')
                    ->helperText('Pisahkan dengan koma, misalnya: herbal, suplemen, Gamora'),
                Forms\Components\FileUpload::make('image')
                    ->label('OG Image')
                    ->image()
                    ->directory('meta-images')
                    ->helperText('Gambar untuk Open Graph/Twitter Card.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('url')
                    ->label('Page URL')
                    ->formatStateUsing(fn($state) => url($state))
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Meta Title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Meta Description')
                    ->limit(50),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMetaTags::route('/'),
            'create' => Pages\CreateMetaTag::route('/create'),
            'edit' => Pages\EditMetaTag::route('/{record}/edit'),
        ];
    }
}