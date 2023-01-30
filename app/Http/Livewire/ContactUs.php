<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Contact;

class ContactUs extends Component
{
   
    

        public $name;
        public $email;
        public $message;


        public function updated($fields)
        {
            $this->validateOnly($fields,[
                'name' => 'required',
                'email' => 'required|email',
                'message' => 'required'
            ]);

        }

        public function sendMessage()
        {
            $this->validate([
                'name' => 'required',
                'email' => 'required|email',
                'message' => 'required'
            ]);
            $contact = new Contact();
            $contact->$name = $this->name;
            $contact->$email = $this->email;
            $contact->$message = $this->message;
            $contact->save();
            session()->flash('message','Thank you, Your message has been sent successfully!');
        }
        public function render()
    {
        return view('livewire.contact-us')->layout('layouts.base');
    }
}
