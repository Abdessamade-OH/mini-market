<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Checkout extends Component
{
    public function render()
    {
        if (Auth::check()) {
            $shipping = 120;
            $subtotal = 0;
            foreach(auth()->user()->products as $product)
            {
                $subtotal += $product->prix * $product->pivot->quantity;
            }
            $total = $subtotal + $shipping;
            $products = auth()->user()->products->all();
            return view('livewire.checkout', [
                'products' => $products,
                'subtotal' => $subtotal,
                'total' => $total,
                'shipping' => $shipping,
            ])->layout('layouts.base', [
                'total' => $subtotal,
                'products' => $products
            ]);
        }
        else
        {
            return view('livewire.checkout')->layout('layouts.base');
        }
    }
 }
