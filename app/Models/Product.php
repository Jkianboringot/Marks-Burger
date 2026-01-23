<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{

    public $fillable = ['name', 'price'];

    // protected $fillable = ['name','unit_cost','description','status','category_id','is_active'];


    // protected $casts = ['status' => ProductStatusEnum::class];

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

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'product_ingredient')
            ->withPivot(['price', 'quantity']);
    } //might cause error, i feel it

//playground
    // public function category(): BelongsTo{ //in filament it needs to be strict type, if or has a type in fucntion, if not it will break
    //   return $this->belongsTo(Category::class);
    // }

    // public function tags(): BelongsToMany{
    //   return $this->belongsToMany(Tag::class);
    // }

}
