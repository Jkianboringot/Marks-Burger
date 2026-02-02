<?php

namespace App\Models;

use GuzzleHttp\Promise\Is;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AddIngredient extends Model
{
    protected $guard=['id','created_at','updated_at'];

    protected function ingredients(): BelongsToMany{
        return $this->belongsToMany(Ingredient::class,'add_to_ingredient')
        ->withPivot(['quantity']);
    }
}
