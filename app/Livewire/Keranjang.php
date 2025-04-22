<?php

namespace App\Livewire;

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
        $this->cart = session()->get('cart', []);
        $this->calculateTotal();
    }

    public function increaseQuantity($id)
    {
        $cart = session()->get('cart');
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
            session()->put('cart', $cart);
        }
        $this->cart = $cart;
        $this->dispatch('cart-updated');
    }

    public function decreaseQuantity($id)
    {
        $cart = session()->get('cart');
        if (isset($cart[$id]) && $cart[$id]['quantity'] > 1) {
            $cart[$id]['quantity']--;
            session()->put('cart', $cart);
        }
        $this->cart = $cart;
        $this->dispatch('cart-updated');
    }


    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);
        $this->loadCart();

        $this->dispatch('cart-updated');
        $this->dispatch('toastr', type: 'error', message: 'Produk di hapus dari keranjang!');
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
