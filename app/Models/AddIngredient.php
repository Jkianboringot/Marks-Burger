<?php

namespace App\Models;

use GuzzleHttp\Promise\Is;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AddIngredient extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'add_to_ingredient')
            ->withPivot(['quantity']);
    }

      public function branches(): BelongsToMany
    {
        return $this->belongsToMany(Branch::class, 'add_to_ingredient')
            ->withPivot(['quantity']);
        ;
    }

    
    // public function add_ingredients(): BelongsToMany
    // {
    //     return $this->belongsToMany(AddIngredient::class, 'add_to_ingredient')
    //         ->withPivot(['quantity']);
    // }
}
