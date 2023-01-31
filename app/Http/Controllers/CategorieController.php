<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategorieController extends Controller
{
    public function index()
    {
        $categories = Categorie::all();

        return view('crud.categories');
    }

    public function shop()
    {

        if (Auth::check()) {
            $total = 0;
            foreach(auth()->user()->products as $product)
            {
                $total += $product->prix * $product->pivot->quantity;
            }
            $products = auth()->user()->products->all();
            return view('shopLayout', ['total' => $total, 'products' => $products,]);
        }
        else
        {
            return view('layouts.base');
        }
    }
}
