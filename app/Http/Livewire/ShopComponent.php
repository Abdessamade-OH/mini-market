<?php

namespace App\Http\Livewire;

use App\Models\Categorie;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ShopComponent extends Component
{
    use WithPagination;
    
    public $choosen = 'all';
    
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
            ]);
        }
        else
        {
            return view('livewire.shop-component', [
                'categories' => $categories,
            ]);
        }
    }

    public function chooseCategory($id)
    {
        dd($id);
        $this->choosen = $id;
    }
}
