<?php
namespace App\Livewire;

use App\Models\UserCart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SideCart extends Component
{
    public $cart = [];
    public $total = 0;
    public $displayedCart = [];
    public $remainingItems = 0;

    protected $listeners = ['cart-updated' => 'loadCart'];

    public function mount()
    {
        $this->reset(['cart', 'displayedCart', 'remainingItems', 'total']);
        $this->loadCart();
    }

    public function loadCart()
    {
        if (Auth::check()) {
            // Jika pengguna login, ambil keranjang dari database
            $this->cart = UserCart::where('id_user', Auth::id())->get()->map(function ($item) {
                // Periksa apakah produk terkait ada
                $product = $item->product; // Mengambil relasi 'product'

                // Jika produk tidak ditemukan, kita bisa mengembalikan null atau data kosong
                if (!$product) {
                    return null; // Ini bisa diganti sesuai kebutuhan
                }

                return [
                    'id' => $item->id,
                    'nama' => $product->nama_product,
                    'harga' => $product->harga,
                    'quantity' => $item->quantity,
                    'gambar' => $product->getFirstMediaUrl('foto_product'),
                ];
            })->filter()->values()->toArray();
        } else {
            // Jika pengguna belum login, ambil keranjang dari session
            $this->cart = session()->get('cart', []);
        }

        $this->prepareDisplayedCart();
        $this->calculateTotal();
    }

    public function prepareDisplayedCart()
    {
        $this->displayedCart = array_slice($this->cart, 0, 3, true);
        $this->remainingItems = count($this->cart) - count($this->displayedCart);
    }


    public function removeFromCart($id)
    {
        if (Auth::check()) {
            UserCart::where('id', $id)->where('id_user', Auth::id())->delete();
        } else {
            // Hapus item dari session jika pengguna belum login
            $cart = session()->get('cart', []);
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

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
