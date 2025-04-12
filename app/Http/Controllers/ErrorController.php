<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function notFound()
    {
        $kategoris = Kategori::with('product')->get();
        return view('errors.404', compact('kategoris'));
    }
}
