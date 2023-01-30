<?php

namespace App\Http\Livewire;

use App\Models\Categorie;
use Livewire\Component;
use Livewire\WithPagination;

class Categories extends Component
{
    use WithPagination;

    public $q;
    public $sortBy = 'id';
    public $sortAsc = true;
    public $category;

    public $confirmingCategoryDeletion = false;
    public $confirmingCategoryAdd = false;
    public $confirmingCategoryEdit = false;

    protected $queryString = [
        'q' => ['except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortAsc' => ['except' => true],
        
        //we do the except to only show the query strings when they are used
    ];

    protected $rules = [
        'category.name' => 'required|string|min:3',
        'category.description' => 'required|string|min:10',
        'category.icon_class' => 'string'
    ];
    
    public function render()
    {
         
        $categories = Categorie::where('id', '!=', 0)
            ->when($this->q, function($query){
                return $query->where(function($query){
                    $query->where('name', 'like', '%' . $this->q . '%');
                });
            })
            ->orderBy( $this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');
            
        $categories = $categories->paginate(10);

        return view('livewire.categories', [
            'categories' => $categories,
        ]);
    }

    public function updatingQ()
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

    public function confirmCategoryDeletion($id)
    {
        $this->confirmingCategoryDeletion = $id;
    }

    public function deleteCategory(Categorie $category) //model binding (we passed in the id)
    {
        $category->delete();
        $this->confirmingCategoryDeletion = false;
        $this->resetPage();
        session()->flash('message', 'category Deleted successfully');
    }

    public function confirmCategoryAdd() 
    {
        $this->reset(['category']);
        $this->confirmingCategoryAdd = true;
    }

    public function confirmCategoryEdit(Categorie $category) 
    {
        $this->category = $category;
        //dd($this->category);
        $this->confirmingCategoryAdd = true;
    }

    public function saveCategory()
    {
        //dd($this->category);
        //$this->validate();
        //dd($this->category);
        if(isset($this->category->id))
        {
            //dd($this->category);
            $this->category->save();
            //dd($this->category);
            session()->flash('message', 'category Saved successfully');
        }
        else
        {
            //dd($this->category['name']);
            if(isset($this->category->icon_class))
            {
                Categorie::create([
                    'name' => $this->category['name'],
                    'icon_class' => $this->category['icon_class'],
                    'description' => $this->category['description'],
                    
                ]);
            }
            else
            {
                Categorie::create([
                    'name' => $this->category['name'],
                    'description' => $this->category['description'],
                ]);
            }
            
            session()->flash('message', 'category Added successfully');
        }   
        $this->confirmingCategoryAdd = false;
    }
}

