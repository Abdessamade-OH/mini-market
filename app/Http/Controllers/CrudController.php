<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CrudController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('dashboard');
    }

    public function products()
    {
        return view('crud.crud', [
            'type' => 'products',
        ]);
    }

    public function categories()
    {
        return view('crud.crud', [
            'type' => 'categories',
        ]);
    }

    public function commands()
    {
        return view('crud.crud', [
            'type' => 'commands',
        ]);
    }

    public function clients()
    {
        return view('crud.crud', [
            'type' => 'clients',
        ]);
    }
}
