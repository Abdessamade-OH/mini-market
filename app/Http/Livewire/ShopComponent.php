<?php

namespace App\Http\Livewire;

use App\Models\Categorie;
use App\Models\Product;
use App\Rules\max;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ShopComponent extends Component
{
    use WithPagination;
    
    public $choosen = 'all';
    public $q;
    public $product;
    public $quantity;

    public $confirmingProductBuy = false;
    
    public function render()
    {
        
        $products = Product::where('id', '!=', 0)
            ->when($this->q, function($query){
                return $query->where(function($query){
                    $query->where('name', 'like', '%' . $this->q . '%')
                        ->orWhere('prix', 'like', '%'. $this->q . '%');
                });
            })
            ->when($this->choosen, function($query){
                if($this->choosen === 'all'){
                    return $query;
                }
                else
                {
                    return $query->where('categorie_id', '=', $this->choosen);
                }
            });
            
        

        $categories = Categorie::all();
        $products = $products->paginate(10);
        $selected = Categorie::find($this->choosen);
        return view('livewire.shop-component', [
                'categories' => $categories,
                'products' => $products,
                'selected' => $selected
        ]);

        if(Auth::check()) {
            $total = 0;
            foreach(auth()->user()->products as $product)
            {
                $total += $product->prix * $product->pivot->quantity;
            }
            $producto = auth()->user()->products->all();
            return view('livewire.shop-component', [
                'categories' => $categories,
                'products' => $products,
                'selected' => $selected
        ])->layout('layouts.base', ['total' => $total, 'products' => $producto,]);
        }
        else
        {
            return view('livewire.shop-component', [
                'categories' => $categories,
                'products' => $products,
                'selected' => $selected
        ])->layout('layouts.base');
        }
    }

    public function updatingQ()
    {
        $this->resetPage();
    }

    public function updatingChoosen()
    {
        $this->resetPage();
    }

    public function confirmProductBuy(Product $product) 
    {
        $this->validate([
            'quantity' => ['required', 'numeric', 'min:1', new max($product->stock)],
        ]);
        $this->product = $product;
        auth()->user()->products()->attach($this->product, ['quantity' => $this->quantity]);
        $this->confirmingProductBuy = true;

        $this->reset('quantity');
    }


}
