<?php

namespace App\Http\Controllers;

use App\Models\Hero;
use App\Models\Post;
use App\Models\Promo;
use App\Models\Product;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HomeController extends Controller
{
    public function index($kategoriSlug = null)
    {
        $hero = Hero::with('product')->get();
        $posts = Post::with('kategori', 'tags')->latest()->paginate(6); // untuk daftar utama
        $kategori = Kategori::with('product')->get();
        $product = Product::with('kategori')->get();
        $produk = Product::with('kategori')->get();
        $prodkats = Product::with('kategori')->get();
        $kategoris = Kategori::with('product')->get();
        $kat = Kategori::all();
        $promo = Promo::inRandomOrder()->limit(3)->get();
        $SingleProduct = Product::with('kategori')->inRandomOrder()->first();
        return view('home', compact('hero', 'kategori', 'product', 'SingleProduct', 'promo', 'kategoris', 'produk', 'prodkats', 'kat', 'kategoriSlug', 'posts'));
    }
}
