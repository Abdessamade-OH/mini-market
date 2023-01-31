<?php

namespace App\Http\Livewire;

use App\Models\Categorie;
use Livewire\Component;

class ShopComponent extends Component
{
    public function render()
    {
        $categories = Categorie::all();
        return view('livewire.shop-component', [
            'categories' => $categories,
        ])->layout('layouts.base');
    }
}
