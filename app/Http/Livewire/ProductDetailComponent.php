<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ProductDetailComponent extends Component
{
    public function render()
    {
        return view('livewire.product-detail-component')->layout('layouts.base');
    }
}
