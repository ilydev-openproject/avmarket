<?php

namespace App\Livewire;

use Livewire\Component;

class SideCart extends Component
{
    public $cart = [];
    public $total = 0;
    public $displayedCart = []; // Tambah property untuk cart yang ditampilkan
    public $remainingItems = 0; // Tambah property untuk sisa item

    protected $listeners = ['cart-updated' => 'loadCart'];

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        $this->cart = session()->get('cart', []);
        $this->prepareDisplayedCart();
        $this->calculateTotal();
    }

    public function prepareDisplayedCart()
    {
        $this->displayedCart = array_slice($this->cart, 0, 5, true);
        $this->remainingItems = count($this->cart) - count($this->displayedCart);
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
        return view('livewire.side-cart');
    }
}
