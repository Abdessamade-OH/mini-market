<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'icon_class'];
    
    public function produits(){
        return $this->hasMany(Produit::class);
    }

    /* public function image(){
        return $this->morphOne(Image::class, 'imageable');
    } */
}
