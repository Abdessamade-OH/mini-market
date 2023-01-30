<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class AdminContactUs extends Component
{
    public function render()
    {
        $contacts = Contact::paginate(12);
        return view('livewire.admin.admin-contact-us', ['contacts'=>$contacts])->layout('layouts.base');
    }
}
