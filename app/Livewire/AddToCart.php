<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class AddToCart extends Component
{
    public $productId;
    public string $view = 'livewire.add-to-cart';

    public function addToCart()
    {
        $product = Product::findOrFail($this->productId);
        $cart = session()->get('cart', []);

        if (isset($cart[$this->productId])) {
            $cart[$this->productId]['quantity'] += 1;
        } else {
            $cart[$this->productId] = [
                'nama' => $product->nama_product,
                'harga' => $product->harga,
                'gambar' => $product->getFirstMediaUrl('foto_product'),
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);

        $this->dispatch('cart-updated'); // ⬅️ penting untuk counter!
        $this->dispatch('toastr', type: 'success', message: 'Produk ditambahkan ke keranjang!');
    }


    public function render()
    {
        return view($this->view);
    }
}
