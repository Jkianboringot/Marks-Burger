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


    public function orders(): int
    {

        return Order::join('product_orders', 'orders.id', '=', 'product_orders.order_id')
        ->sum('product_orders.quantity');
    }

    public function stock(): int
    {
        return max(($this->addIngredients()->sum('add_to_ingredient.quantity') ?? 0)
         -$this->orders()
         ,0);
        //okay currently this works but we need to have checks like making sure a transaction will not go through if 
        //this become zero, that is done in resource i think, also i need to cache this, or make it ledger-derived balance
        //for system or caching it somewhere and if its not auto calculte it we cal this, becuase am sure, this is heavy in 
        //query especially because of orders method, which has no relation with ingredient, make this better, and think it over
        //and over again



        //         // - ($this->addIngredients()->sum('add_to_ingredient.quantity') ?? 0),
        //         //ok now the problem how the fuck are we suppose to decrease i really did not design this well did i
        //         //i need to figure out how can i conenct to product_order in here when i do that , am done with this,
        //         //i could just brute force it for now and call order,lets try temporarly

        //     0
        // );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Ingredient::class);
    }
}
