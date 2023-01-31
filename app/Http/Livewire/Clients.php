<?php

namespace App\Http\Livewire;

use App\Mail\NormalMarkdownMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Clients extends Component
{
    use WithPagination;
    use WithFileUploads;    

    public $q;
    public $sortBy = 'id';
    public $sortAsc = true;
    public $banned;
    public $active;
    public $utype;
    public $clients;
    public $object;
    public $content;
    public $file;

    public $confirmingUserDeletion = false;
    public $confirmingUserEdit = false;
    public $confirmingUserBan = false;
    public $confirmingUserPromotion = false;
    public $confirmingUserEmail = false;

    protected $queryString = [
        'q' => ['except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortAsc' => ['except' => true],
    ];

    protected $rules = [
        'category.name' => 'required|string|min:3',
        'category.description' => 'required|string|min:10',
        'category.icon_class' => 'required|string',
        'mail.object' => 'required|string|min:3',
        'mail.content' => 'required|string|min:5',
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
            })->when(auth()->user()->utype !== 'SAD', function($query){
                return $query->where('utype', 'USR');
            })->when($this->clients, function($query){
                return $query->where('utype', 'USR');
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

    public function confirmUserEmail($id)
    {
        $this->confirmingUserEmail = $id;
        $this->reset(['object', 'content', 'file']);
    }

    public function confirmUserPromotion(User $user)
    {
        $this->confirmingUserPromotion = $user->id;
        $this->utype = $user->utype;
    }


    public function deleteUser(User $user) //model binding (we passed in the id)
    {
        $user->delete();
        $this->confirmingUserDeletion = false;
        $this->resetPage();
        session()->flash('message', 'user Deleted successfully');
    }

    public function banUser(User $user)
    {
        if($user->banned)
        {
            $user->banned= 0;
            session()->flash('message', 'user Unbanned successfully');
        }
        else
        {
            $user->banned= 1;
            session()->flash('message', 'user Banned successfully');
        }

        $user->save();
        $this->confirmingUserBan = false;
    }

    public function promoteUser(User $user)
    {
        if($user->utype === 'USR')
        {
            $user->utype = 'ADM';
            session()->flash('message', 'Client Promoted successfully');
        }
        else
        {
            $user->utype = 'USR';
            session()->flash('message', 'Admin Demoted successfully');
        }

        $user->save();
        $this->confirmingUserPromotion = false;
    }

    public function emailUser(User $user)
    {
        /*$this->mail->validate([
            'object' => ['required', 'string', 'min=5'],
            'content' => ['required', 'string', 'min=10']
        ]);*/
        //dd('test');
        $path = null;
        
        
        $this->validate([
            'object' => ['required', 'string', 'min:3'],
            'content' => ['required', 'string', 'min:5'],
        ]);
        if(isset($this->file))
        {
            $filename = time().'.'.$this->file->extension();

            $path = $this->file->storeAs('email-files', $filename, 'public');
            $path = 'public/'.$path;
            //$path = $this->file->store('/public/email-files');
            //dd($path);
            //$path = Storage::url('email-files/'.$filename);
        }
        Mail::to($user->email)->send(new NormalMarkdownMail(
            $this->object,
            $this->content,
            $user->name, auth()->user(),
            $path
        ));

        $this->confirmingUserEmail = false;
    }
}
