<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ingredient extends Model
{
    protected $fillable = [
        'name',
        'threshold',
        'category_id',
        'unit_id',
        'unit_quantity'
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_ingredients');
    }

  
    public function addIngredients(): BelongsToMany
    {
        return $this->belongsToMany(AddIngredient::class, 'add_to_ingredient')
            ->withPivot(['quantity']);
    }



    public function category(): BelongsTo
    {
        return $this->belongsTo(Ingredient::class);
    }
}
