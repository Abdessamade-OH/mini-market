<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', ' updated_at'];

    public function categorie(){
        return $this->belongsTo(Categorie::class);
    }

    public function scopeOnStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
