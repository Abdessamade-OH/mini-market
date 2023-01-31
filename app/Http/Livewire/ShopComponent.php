<?php

namespace App\Http\Livewire;

use App\Models\Categorie;
use Livewire\Component;

class ShopComponent extends Component
{
    public function render()
    {
        $total = 0;
        foreach(auth()->user()->products as $product)
        {
            $total += $product->prix * $product->pivot->quantity;
        }
        $categories = Categorie::all();
        $products = auth()->user()->products->all();
        return view('livewire.shop-component', [
            'categories' => $categories,
        ])->layout('layouts.base', ['total' => $total, 'products' => $products,]);
    }
}
