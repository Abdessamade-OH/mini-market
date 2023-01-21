<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class AdminSettingsComponent extends Component
{
    public function render()
    {
        return view('livewire.admin.admin-settings-component')->layout('layouts.base');
    }
}
