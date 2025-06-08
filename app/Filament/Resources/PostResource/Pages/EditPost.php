<?php

namespace App\Filament\Resources\PostResource\Pages;

use Filament\Actions;
use Filament\Pages\Actions\Action;
use App\Filament\Resources\PostResource;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Action::make('google_rich_results_test')
                ->label('Tes Schema di Google')
                ->icon('heroicon-o-magnifying-glass')
                ->color('gray') // Membuat warnanya netral
                ->url(
                    // Membuat URL tes secara dinamis berdasarkan slug post saat ini
                    fn($record): string => 'https://search.google.com/test/rich-results?url=' . url($record->slug),
                    // Membuka URL di tab browser baru
                    shouldOpenInNewTab: true
                ),
        ];
    }
}
