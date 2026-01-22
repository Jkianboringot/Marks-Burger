<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Branch extends Model
{
    protected $fillable = ['location','type_branch'];

    
     public function ingredients(): BelongsToMany{
        return $this->belongsToMany(Ingredient::class,'ingredient_branch')
        ->withPivot(['quantity']);
    }

      public function orders()
    {
        return $this->belongsToMany(Order::class, 'product_order')
        ->withPivot(['quantity', 'price']);
    }


      public function reuturneds()
    {
        return $this->belongsToMany(Returned::class, 'product_return')
        ->withPivot(['quantity', 'price']);
    }


}
