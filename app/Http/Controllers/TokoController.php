<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Kategori;
use App\View\Components\Home\Produk;
use Illuminate\Http\Request;

class TokoController extends Controller
{
    public function index()
    {
        $kategori = Kategori::with('product')->get();
        $product = Product::with('kategori')->get();
        $produk = Product::with('kategori')->get();
        $prodkats = Product::with('kategori')->get();
        $kategoris = Kategori::with('product')->get();
        $kat = Kategori::all();
        $products = Product::with('kategori')->get();
        $kategoriSlug = null;
        return view('toko', compact('kategori', 'product', 'products', 'kategoris', 'produk', 'prodkats', 'kat', 'kategoriSlug'));
    }

    public function detail($slug)
    {
        $product = Product::with('kategori', 'tags')->where('slug', $slug)->firstOrFail();

        $relatedProducts = Product::where('id_kategori', $product->id_kategori)
            ->where('id', '!=', $product->id)
            ->latest()
            ->take(6)
            ->get();

        $recentProduct = Product::with('kategori', 'tags')->latest()->limit(3)->get();

        $meta = [
            'meta_title' => $product->nama_product ?? $product->title,
            'meta_description' => $product->deskripsi ?? \Str::limit(strip_tags($product->content), 150),
            'meta_keywords' => $product->keywords ?? $product->title,
            'meta_image' => $product->getFirstMediaUrl('foto_product') ?? asset('image/logo/icon.png'),
            'meta_url' => url()->current(),
        ];

        return view('detail', compact('product', 'relatedProducts', 'recentProduct', 'meta'));
    }



    public function kategori($kategoriSlug)
    {
        $kategori = Kategori::where('slug', $kategoriSlug)->firstOrFail();  // Ambil kategori berdasarkan slug

        // Ambil produk berdasarkan kategori
        $products = Product::where('id_kategori', $kategori->id)->paginate(10);
        $kategoris = Kategori::with('product')->get();
        return view('toko', compact('kategoriSlug', 'products', 'kategoris'));
    }
}
