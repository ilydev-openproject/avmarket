<?php

namespace App\Livewire;

use App\Models\UserCart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Keranjang extends Component
{
    public $cart = [];
    public $total = 0;

    protected $listeners = ['cart-updated' => 'loadCart'];

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        if (Auth::check()) {
            $this->cart = UserCart::where('id_user', Auth::id())->get()->map(function ($item) {
                $product = $item->product;
                if (!$product)
                    return null;

                return [
                    'id' => $item->id, // ID keranjang, bukan ID produk
                    'id_product' => $item->id_product,
                    'nama' => $product->nama_product,
                    'harga' => $product->harga,
                    'quantity' => $item->quantity,
                    'gambar' => $product->getFirstMediaUrl('foto_product'),
                ];
            })->filter()->values()->toArray();
        } else {
            $this->cart = session()->get('cart', []);
        }

        $this->calculateTotal();
    }

    public function increaseQuantity($id)
    {
        if (Auth::check()) {
            $cartItem = UserCart::find($id);
            if ($cartItem && $cartItem->id_user === Auth::id()) {
                $cartItem->increment('quantity');
            }
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$id])) {
                $cart[$id]['quantity']++;
                session()->put('cart', $cart);
            }
            $this->cart = $cart;
        }

        $this->loadCart();
        $this->dispatch('cart-updated');
    }

    public function decreaseQuantity($id)
    {
        if (Auth::check()) {
            $cartItem = UserCart::find($id);
            if ($cartItem && $cartItem->id_user === Auth::id() && $cartItem->quantity > 1) {
                $cartItem->decrement('quantity');
            }
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$id]) && $cart[$id]['quantity'] > 1) {
                $cart[$id]['quantity']--;
                session()->put('cart', $cart);
            }
            $this->cart = $cart;
        }

        $this->loadCart();
        $this->dispatch('cart-updated');
    }

    public function removeFromCart($id)
    {
        if (Auth::check()) {
            UserCart::where('id', $id)->where('id_user', Auth::id())->delete();
        } else {
            $cart = session()->get('cart', []);
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        $this->loadCart();
        $this->dispatch('cart-updated');
        $this->dispatch('toastr', type: 'error', message: 'Produk dihapus dari keranjang!');
    }

    public function calculateTotal()
    {
        $this->total = array_reduce($this->cart, function ($carry, $item) {
            return $carry + ($item['harga'] * $item['quantity']);
        }, 0);
    }

    public function render()
    {
        return view('livewire.keranjang');
    }
}
