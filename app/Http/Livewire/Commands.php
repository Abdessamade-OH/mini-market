<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Rules\max;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Commands extends Component
{
    use WithPagination;

    public $q;
    public $sortBy = 'id';
    public $sortAsc = true;
    public $quantity = false;
    public $userID = false;
    public $max;

    public $confirmingCommandDeletion = false;
    public $confirmingCommandEdit = false;
    public $confirmingCommandAllDeletion = false;

    protected $queryString = [
        'q' => ['except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortAsc' => ['except' => true],
        
        //we do the except to only show the query strings when they are used
    ];

    public $rules = [
        'quantity' => 'required| min:1 | max:5000',
    ];
    
    public function render()
    {
         
        $clients = User::where('utype', '!=', 'ADM')->where('utype', '!=', 'SAD')
            ->when($this->q, function($query){
                return $query->where(function($query){
                    $query->where('name', 'like', '%' . $this->q . '%');
                });
            })
            ->orderBy( $this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');
            
        $clients = $clients->paginate(3);

        return view('livewire.commands', [
            'clients' => $clients,
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

    public function confirmCommandDeletion($userID, $id)
    {
        $this->confirmingCommandDeletion = $id;
        $this->userID = $userID;
        //dd($this->userID, $this->confirmingCommandDeletion);
    }
    public function confirmCommandAllDeletion($id)
    {
        $this->confirmingCommandAllDeletion = $id;
    }
    public function confirmCommandEdit($id, $max)
    {
        $this->max = $max;
        $this->confirmingCommandEdit = $id;
    }

    public function deleteCommand() //model binding (we passed in the id)
    {
        //dd($user->id, $this->confirmingCommandDeletion);
        //$user->products()->detach([$this->confirmingCommandDeletion]);
        DB::delete('delete from product_user where id = ?', array($this->confirmingCommandDeletion));
        $this->confirmingCommandDeletion = false;
        $this->resetPage();
        session()->flash('message', 'command Deleted successfully');
    }

    public function deleteAllCommands(User $user)
    {
        $user->products()->detach();
        $this->confirmingCommandAllDeletion = false;
        $this->resetPage();
        session()->flash('message', 'commands Deleted successfully');
    }

    public function saveCommand()
    {
        $this->validate([
            'quantity' => ['required', 'numeric', 'min:1', new max($this->max)],
        ]);
        DB::update('update product_user set quantity = ? where id = ?', array($this->quantity, $this->confirmingCommandEdit));
        $this->confirmingCommandEdit = false;
        $this->quantity = false;
        $this->resetPage();
        session()->flash('message', 'command quanity saved successfully');
    }
}
