<?php

namespace App\Http\Livewire;

use App\Models\Categorie;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ShopComponent extends Component
{
    use WithPagination;
    
    public $choosen = 'all';
    public $q;

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
        return view('livewire.product-detail-component');
    }

    public function buyProduct(Product $product)
    {
        dd('test');
    }

}
