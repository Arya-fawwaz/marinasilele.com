<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Menampilkan halaman keranjang belanja dengan proteksi ganda
    public function index()
    {
        $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();
        
        $hasDeletedItem = false;
        foreach($cartItems as $item) {
            if(!$item->product) {
                $item->delete();
                $hasDeletedItem = true;
            }
        }

        if($hasDeletedItem) {
            $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();
        }
        
        return view('cart.index', compact('cartItems'));
    }

    // Menambah produk ke keranjang
    public function add(Request $request, Product $product)
    {
        $request->validate(['quantity' => 'required|integer|min:1|max:' . $product->stock]);

        $cartItem = Cart::where('user_id', auth()->id())->where('product_id', $product->id)->first();

        if ($cartItem) {
            $cartItem->update(['quantity' => $cartItem->quantity + $request->quantity]);
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => $request->quantity
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    // Mengupdate jumlah produk di keranjang
    public function update(Request $request, Cart $item)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);
        $item->update(['quantity' => $request->quantity]);
        return redirect()->back()->with('success', 'Jumlah produk diperbarui!');
    }

    // Menghapus produk dari keranjang
    public function remove(Cart $item)
    {
        $item->delete();
        return redirect()->back()->with('success', 'Produk dihapus dari keranjang!');
    }
}