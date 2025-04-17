<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class AddToFavorite extends Component
{

    public $productId;
    public string $view = 'livewire.add-to-favorite';
    public $isFavorite = false;

    public function addToFavorite()
    {
        $product = Product::findOrFail($this->productId);

        $favorite = session()->get('favorite', []);

        if (!isset($favorite[$this->productId])) {
            $favorite[$this->productId] = [
                'nama' => $product->nama_product,
                'harga' => $product->harga,
                'gambar' => $product->getFirstMediaUrl('foto_product'),
            ];
        }

        session()->put('favorite', $favorite);

        $this->dispatch('favorite-updated');
    }

    public function render()
    {
        return view($this->view);
    }
}
