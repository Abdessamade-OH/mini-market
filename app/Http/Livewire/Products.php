<?php

namespace App\Http\Livewire;

use App\Models\Categorie;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Products extends Component
{
    use WithPagination;

    public $onStock;
    public $q;
    public $category='all';
    public $sortBy = 'id';
    public $sortAsc = true;
    public $product;

    public $confirmingProductDeletion = false;
    public $confirmingProductAdd = false;
    public $confirmingProductEdit = false;

    protected $queryString = [
        'onStock' => ['except' => false],
        'q' => ['except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortAsc' => ['except' => true],
        'category' => ['except' => 'all']
        
        //we do the except to only show the query strings when they are used
    ];

    protected $rules = [
        'product.name' => 'required|string|min:3',
        'product.description' => 'required|string|min:10',
        'product.prix' => 'required|numeric|between:0.05,1000000',
        'product.stock' => 'required|numeric|between:0,500',
        'product.categorie_id' => 'required|numeric' 
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
            ->when($this->onStock, function( $query ){
                return $query->onStock();
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
            
        $products = $products->paginate(10);

        $categories = Categorie::all();

        return view('livewire.products', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    //updates the pagination when the expensive model is checked
    public function updatingOnStock()
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

    public function confirmProductDeletion($id)
    {
        $this->confirmingProductDeletion = $id;
        //$product->delete();
    }

    public function deleteProduct(Product $product) //model binding (we passed in the id)
    {
        $product->delete();
        $this->confirmingProductDeletion = false;
        $this->resetPage();
        session()->flash('message', 'product Deleted successfully');
        
    }

    public function confirmProductAdd() 
    {
        $this->reset(['product']);
        $this->confirmingProductAdd = true;
    }

    public function confirmProductEdit(Product $product) 
    {
        $this->product = $product;
        $this->confirmingProductAdd = true;
    }

    public function saveProduct()
    {
        $this->validate();
        if(isset($this->product->id))
        {
            $this->product->save();
            session()->flash('message', 'product Saved successfully');
        }
        else
        {
            Product::create([
                'name' => $this->product['name'],
                'description' => $this->product['description'],
                'prix' => $this->product['prix'],
                'stock' => $this->product['stock'],
                'categorie_id' => $this->product['categorie_id'],
            ]);
            session()->flash('message', 'product Added successfully');
        }   
        $this->confirmingProductAdd = false;
    }
}
