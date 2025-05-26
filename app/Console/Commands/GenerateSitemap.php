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
        $sitemap = Sitemap::create()->add('/');

        // Tambahkan produk
        \App\Models\Product::all()->each(function ($product) use ($sitemap) {
            $sitemap->add(route('product.detail', $product->slug));
        });

        // Tambahkan postingan
        \App\Models\Post::all()->each(function ($post) use ($sitemap) {
            $sitemap->add(route('blog.show', $post->slug));
        });

        // Tambahkan dari MetaTag jika perlu
        \App\Models\MetaTag::all()->each(function ($meta) use ($sitemap) {
            if (!empty($meta->url)) {
                $sitemap->add($meta->url);
            }
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));
        $this->info('Sitemap generated!');
    }

}