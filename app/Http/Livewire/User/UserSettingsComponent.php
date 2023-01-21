<?php

namespace App\Http\Livewire\User;

use Livewire\Component;

class UserSettingsComponent extends Component
{
    public function render()
    {
        return view('livewire.user.user-settings-component')->layout('layouts.base');
    }
}
