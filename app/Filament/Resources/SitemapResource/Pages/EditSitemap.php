<?php

namespace App\Filament\Resources\SitemapResource\Pages;

use App\Filament\Resources\SitemapResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSitemap extends EditRecord
{
    protected static string $resource = SitemapResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
