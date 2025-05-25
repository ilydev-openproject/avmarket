<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Post;
use App\Models\MetaTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class SetMetaTags
{
    public function handle(Request $request, Closure $next)
    {
        // Default meta tags
        $meta = [
            'title' => 'Gamora | Toko Herbal Online',
            'description' => 'Belanja produk herbal alami di Gamora, toko herbal online terpercaya.',
            'keywords' => 'toko herbal, produk herbal, suplemen alami, Gamora',
            'image' => asset('image/logo/icon.png'),
            'url' => $request->url(),
        ];

        // Cari meta tag berdasarkan URL
        $metaTag = MetaTag::where('url', $request->path())->first();
        if ($metaTag) {
            $meta['title'] = $metaTag->title ?? $meta['title'];
            $meta['description'] = $metaTag->description ?? $meta['description'];
            $meta['keywords'] = $metaTag->keywords ?? $meta['keywords'];
            $meta['image'] = $metaTag->image ? asset('storage/' . $metaTag->image) : $meta['image'];
        }

        if ($request->routeIs('blog.show')) {
            $post = Post::where('slug', $request->route('slug'))->first();

            if ($post) {
                $meta['title'] = $post->meta_title ?? $post->title;
                $meta['description'] = $post->meta_description ?? \Str::limit(strip_tags($post->content), 150);
                $meta['keywords'] = $post->meta_keywords ?? $post->title;
                $meta['image'] = asset('image/logo/icon.png');
            }
        }

        // Bagikan data ke view
        View::share('meta', $meta);

        return $next($request);
    }
}