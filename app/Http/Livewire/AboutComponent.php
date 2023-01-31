<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AboutComponent extends Component
{
    public function render()
    {
        $total = 0;
        foreach(auth()->user()->products as $product)
        {
            $total += $product->prix * $product->pivot->quantity;
        }
        $products = auth()->user()->products->all();
        return view('livewire.about-component')->layout('layouts.base', ['total' => $total, 'products' => $products,]);
    }
}
