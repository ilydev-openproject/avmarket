<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Models\UserCart;
use Illuminate\Support\Facades\Auth;

class AddToCart extends Component
{
    public $productId;
    public string $view = 'livewire.add-to-cart';

    public function addToCart()
    {
        $product = Product::findOrFail($this->productId);
        $cart = session()->get('cart', []);

        if (Auth::check()) {
            // Cek apakah produk sudah ada di cart database user
            $userCart = UserCart::where('id_user', Auth::id())
                ->where('id_product', $this->productId)
                ->first();

            if ($userCart) {
                $userCart->increment('quantity');
            } else {
                UserCart::create([
                    'id_user' => Auth::id(),
                    'id_product' => $this->productId,
                    'quantity' => 1,
                ]);
            }
        } else {
            // Simpan di session untuk guest
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
        }

        $this->dispatch('cart-updated');
        $this->dispatch('toastr', type: 'success', message: 'Produk ditambahkan ke keranjang!');
    }


    public function render()
    {
        return view($this->view);
    }
}
