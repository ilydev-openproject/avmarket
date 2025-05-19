<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use App\Models\MetaTag;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate the sitemap';

    public function handle()
    {
        $sitemap = Sitemap::create()
            ->add('/');

        MetaTag::all()->each(function ($metaTag) use ($sitemap) {
            $sitemap->add($metaTag->url);
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));
        $this->info('Sitemap generated!');
    }
}