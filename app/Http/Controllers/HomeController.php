<?php

namespace App\Http\Controllers;

use App\Models\Hero;
use App\Models\Kategori;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $hero = Hero::with('product')->get();
        $kategori = Kategori::with('product')->get();
        $product = Product::with('kategori')->get();
        return view('home', compact('hero', 'kategori', 'product'));
    }
}
