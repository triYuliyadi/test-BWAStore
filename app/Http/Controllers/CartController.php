<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index() 
    {
        // Panggil data dari cart
        $carts = Cart::with(['product.galleries','user'])
            ->where('users_id', Auth::user()->id)
            ->get();

        return view('pages.cart', [
            'carts' => $carts
        ]);
    }

    // Fungsi delete
    public function delete(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);
        
        $cart->delete();

        return redirect()->route('cart');
    }

    // Controller Success
    public function success() 
    {
        return view('pages.success');
    }
}
