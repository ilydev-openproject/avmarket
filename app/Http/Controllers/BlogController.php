<?php
namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Kategori;
use App\Models\Tags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::with('kategori', 'tags')->where('is_published', '1')->latest()->paginate(6); // untuk daftar utama
        $carposts = Post::with('kategori', 'tags')->where('is_published', '1')->latest()->take(5)->get(); // untuk carousel
        $kategoris = Kategori::all();
        $tags = Tags::all();
        $recentPosts = Post::latest()->where('is_published', '1')->take(3)->get();

        return view('blog.index', compact('posts', 'carposts', 'kategoris', 'tags', 'recentPosts'));
    }

    public function byKategori($kategoriSlug = null)
    {
        $posts = Post::with('kategori', 'tags')->where('is_published', '1')->latest()->paginate(6); // untuk daftar utama
        $carposts = Post::with('kategori', 'tags')->where('is_published', '1')->latest()->take(5)->get(); // untuk carousel
        $kategoris = Kategori::all();
        $tags = Tags::all();
        $recentPosts = Post::latest()->take(3)->get();

        return view('blog.index', compact('posts', 'carposts', 'kategoris', 'tags', 'recentPosts', 'kategoriSlug'));
    }

    public function byTag($tagSlug = null)
    {
        $posts = Post::with('kategori', 'tags')->where('is_published', '1')->latest()->paginate(6); // untuk daftar utama
        $carposts = Post::with('kategori', 'tags')->where('is_published', '1')->latest()->take(5)->get(); // untuk carousel
        $kategoris = Kategori::all();
        $tags = Tags::all();
        $recentPosts = Post::latest()->take(3)->get();

        return view('blog.index', compact('posts', 'carposts', 'kategoris', 'tags', 'recentPosts', 'tagSlug'));
    }

    public function show($slug)
    {
        $post = Post::with(['kategori', 'tags'])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();
        $kategori = Kategori::all();
        $tags = Tags::all();

        // Ambil previous dan next post
        $previousPost = Post::where('is_published', true)
            ->where('created_at', '<', $post->created_at)->where('is_published', '1')
            ->orderBy('created_at', 'desc')
            ->first();
        $nextPost = Post::where('is_published', true)->where('is_published', '1')
            ->where('created_at', '>', $post->created_at)
            ->orderBy('created_at', 'asc')
            ->first();
        $meta = [
            // 'meta_title' => $post->meta_title ?? $post->title,
            // 'meta_description' => $post->meta_description ?? \Str::limit(strip_tags($post->content), 150),
            // 'meta_keywords' => $post->meta_keywords ?? $post->title,
            // 'meta_image' => asset('image/logo/icon.png'), // Optional: jika kamu pakai featured image
            // 'meta_url' => url()->current(),
        ];
        return view('blog.show', compact('post', 'kategori', 'tags', 'previousPost', 'nextPost', 'meta'));
    }
}