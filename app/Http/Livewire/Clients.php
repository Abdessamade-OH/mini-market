<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Clients extends Component
{
    use WithPagination;

    public $q;
    public $sortBy = 'id';
    public $sortAsc = true;
    public $banned;
    public $active;

    public $confirmingUserDeletion = false;
    public $confirmingUserEdit = false;
    public $confirmingUserBan = false;

    protected $queryString = [
        'q' => ['except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortAsc' => ['except' => true],
    ];

    protected $rules = [
        'category.name' => 'required|string|min:3',
        'category.description' => 'required|string|min:10',
        'category.icon_class' => 'required|string'
    ];
    
    public function render()
    {
         
        $users = User::where('id', '!=', auth()->user()->id)
            ->when($this->q, function($query){
                return $query->where(function($query){
                    $query->where('name', 'like', '%' . $this->q . '%')
                    ->orWhere('email', 'like', '%'. $this->q . '%');
                });
            })->when($this->active, function($query){
                return $query->where('banned', 0);
            })
            ->orderBy( $this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');
            
        $users = $users->paginate(10);

        return view('livewire.clients', [
            'users' => $users,
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

    public function confirmUserDeletion($id)
    {
        $this->confirmingUserDeletion = $id;
    }

    public function confirmUserBan(User $user)
    {
        $this->confirmingUserBan = $user->id;
        $this->banned = $user->banned;
    }

    public function deleteUser(User $user) //model binding (we passed in the id)
    {
        $user->delete();
        $this->confirmingUserDeletion = false;
        $this->resetPage();
        session()->flash('message', 'user Deleted successfully');
    }

    public function confirmUserEmail(User $user)
    {
        dd('test');
    }

    public function banUser(User $user)
    {
        if($user->banned)
        {
            $user->banned= 0;
            $user->save();
            $this->confirmingUserBan = false;
            session()->flash('message', 'user Unbanned successfully');
        }
        else
        {
            $user->banned= 1;
            $user->save();
            $this->confirmingUserBan = false;
            session()->flash('message', 'user Banned successfully');
        }
    }

}
