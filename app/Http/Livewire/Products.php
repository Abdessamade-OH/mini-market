<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Products extends Component
{
    use WithPagination;
    
    public function render()
    {
        $products = Product::where('categorie_id', 62)
            ->paginate(10); 
        return view('livewire.products');
    }
}
