<?php

namespace App\Http\Livewire;

use App\Models\Categorie;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShopComponent extends Component
{
    public function render()
    {
        $categories = Categorie::all();
        if (Auth::check()) {
            $total = 0;
            foreach(auth()->user()->products as $product)
            {
                $total += $product->prix * $product->pivot->quantity;
            }
            $products = auth()->user()->products->all();
            return view('livewire.shop-component', [
                'categories' => $categories,
            ])->layout('layouts.base', ['total' => $total, 'products' => $products,]);
        }
        else
        {
            return view('livewire.shop-component', [
                'categories' => $categories,
            ])->layout('layouts.base');
        }
    }
}
