<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Tags;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TagsResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TagsResource\RelationManagers;

class TagsResource extends Resource
{
    protected static ?string $model = Tags::class;

    protected static ?string $navigationGroup = 'Kategori';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
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
                    ->columnSpanFull()
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_tag')
                    ->label('Nama Tags'),
                TextColumn::make('slug')
                    ->label('Slug'),
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
            'index' => Pages\ListTags::route('/'),
            'create' => Pages\CreateTags::route('/create'),
            'edit' => Pages\EditTags::route('/{record}/edit'),
        ];
    }
}
