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
        return $this->belongsToMany(Order::class, 'product_orders')
            ->withPivot(['quantity', 'price']);
    }


    public function returneds()
    {
        return $this->belongsToMany(Order::class, 'product_returns')
            ->withPivot(['quantity', 'price']);
    }

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'product_ingredients')
        ->withPivot(['quantity']);
        ;
    } //might cause error, i feel it




// i just need to figure out who can we access ingredient stock in product, take one step at the time

// ok i cannot access the pivot table of ingredient , i think the only way is to create a model for it


    public function productStock():int
    {
          return Ingredient::join('add_to_ingredient', 'ingredients.id', '=', 'add_to_ingredient.ingredient_id')
                            ->sum('add_to_ingredient.quantity');
    }




    // public function orders(): int
    // {

    //     return Order::join('product_orders', 'orders.id', '=', 'product_orders.order_id')
    //         ->sum('product_orders.quantity');
    // }

    // public function returns(): int
    // {

    //     return Returned::join('product_returns', 'returneds.id', '=', 'product_returns.returned_id')
    //         ->sum('product_returns.quantity');
    // }

    // public function ingredientStock(): int
    // {
    //     return max(($this->addIngredients()->sum('add_to_ingredient.quantity') ?? 0)
    //             - $this->returns()
    //             - $this->orders(),
    //         0
    //     );















    //playground
    // public function category(): BelongsTo{ //in filament it needs to be strict type, if or has a type in fucntion, if not it will break
    //   return $this->belongsTo(Category::class);
    // }

    // public function tags(): BelongsToMany{
    //   return $this->belongsToMany(Tag::class);
    // }





}
