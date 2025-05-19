<?php

namespace App\Filament\Resources\SitemapResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Artisan;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\SitemapResource;

class CreateSitemap extends CreateRecord
{
    protected static string $resource = SitemapResource::class;

}
