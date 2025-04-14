<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Kategori;
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
        return view('toko', compact('kategori', 'product', 'products', 'kategoris', 'produk', 'prodkats', 'kat'));
    }

    public function detail($slug)
    {
        $product = Product::with('kategori', 'tags')->where('slug', $slug)->firstOrFail();
        $relatedProducts = Product::where('id_kategori', $product->id_kategori)
            ->where('id', '!=', $product->id)
            ->latest()
            ->take(4)
            ->get();

        return view('detail', compact('product', 'relatedProducts'));
    }
}
