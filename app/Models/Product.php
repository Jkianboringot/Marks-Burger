<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Sanctum\Guard;

class Product extends Model
{
    public $fillable = ['name','price'];


      public function orders()
    {
        return $this->belongsToMany(Order::class, 'product_order')
        ->withPivot(['quantity', 'price']);
    }

     public function returneds()
    {
        return $this->belongsToMany(Order::class, 'product_return')
        ->withPivot(['quantity', 'price']);
    }

     public function ingredients(): BelongsToMany{
        return $this->belongsToMany(Ingredient::class,'product_ingredient')
        ->withPivot(['price','quantity']);
    }//might cause error, i feel it
}
