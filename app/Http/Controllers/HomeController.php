<?php

namespace App\Http\Controllers;

use App\Models\Hero;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $hero = Hero::with('product')->get();
        $kategori = Kategori::with('product')->get();
        return view('home', compact('hero', 'kategori'));
    }
}
