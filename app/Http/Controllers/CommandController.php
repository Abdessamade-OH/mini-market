<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommandController extends Controller
{
    public function index()
    {
        //$clients = Command::all();

        return view('crud.commands');
    }
}
