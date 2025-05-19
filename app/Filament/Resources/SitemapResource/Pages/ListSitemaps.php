<?php

namespace App\Filament\Resources\SitemapResource\Pages;

use Filament\Actions;
use App\Models\Sitemap;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Artisan;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\SitemapResource;

class ListSitemaps extends ListRecords
{
    protected static string $resource = SitemapResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Generate Sitemap')
                ->action(function () {
                    Artisan::call('sitemap:generate');

                    Sitemap::create([
                        'filename' => 'sitemap.xml',
                        'generated_at' => now(),
                    ]);

                    Notification::make()
                        ->title('Sitemap Generated')
                        ->success()
                        ->send();
                })
        ];
    }
}
