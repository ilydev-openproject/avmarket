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

    public  function detail()
    {
        $product = Product::with('Kategori')->where('id', $)
    }
}
