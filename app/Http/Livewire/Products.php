<?php

namespace App\Http\Livewire;

use App\Models\Categorie;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Products extends Component
{
    use WithPagination;

    public $expensive;
    public $q;
    public $category='all';
    public $sortBy = 'id';
    public $sortAsc = true;

    protected $queryString = [
        'expensive' => ['except' => false],
        'q' => ['except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortAsc' => ['except' => true],
        
        //we do the except to only show the query strings when they are used
    ];
    
    public function render()
    {
         
        $products = Product::where('id', '!=', 0)
            ->when($this->q, function($query){
                return $query->where(function($query){
                    $query->where('name', 'like', '%' . $this->q . '%')
                        ->orWhere('prix', 'like', '%'. $this->q . '%');
                });
            })
            ->when($this->expensive, function( $query ){
                return $query->expensive();
            })->when($this->category, function($query){
                if($this->category === 'all'){
                    return $query;
                }
                else
                {
                    return $query->where('categorie_id', $this->category);
                }
            })
            ->orderBy( $this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');
            
        $query = $products->toSql();
        $products = $products->paginate(10);

        $categories = Categorie::all();

        return view('livewire.products', [
            'products' => $products,
            'query' => $query,
            'categories' => $categories,
        ]);
    }

    //updates the pagination when the expensive model is checked
    public function updatingExpensive()
    {
        $this->resetPage();
    }

    public function updatingQ()
    {
        $this->resetPage();
    }

    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {

        if($field == $this->sortBy){
            $this->sortAsc = !$this->sortAsc;
        }
        $this->sortBy = $field;

        //all this function does is specify the field which we'll order with 
    }
}
