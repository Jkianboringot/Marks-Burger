<?php

namespace App\Models;

use App\Models\Pivots\ProductOrder;
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


    public function sold(): void
    {

dd(ProductOrder::join('products','product_orders.product_id','=',"products.id")
->join('product_ingredients','products.id','=','product_ingredients.product_id')->get('*'));
    }

    public function returns(): int
    {

        return Returned::join('product_returns', 'returneds.id', '=', 'product_returns.returned_id')
            ->sum('product_returns.quantity');
    }

    public function ingredientStock(): int
    {
        return ($this->addIngredients()->sum('add_to_ingredient.quantity') ?? 0)
            - $this->returns()
            - $this->orders();


        /*  this is respoble for increase and decreasing stock by use ORM:
        here is raw sql
        //  SELECT SUM(add_to_ingredient.quantity) AS total_quantity
        // FROM ingredients
        // INNER JOIN add_to_ingredient
        //     ON ingredients.id = add_to_ingredient.ingredient_id
         WHERE add_to_ingredient.parent_id = 5;

            this pretty much just take the sum of all ingredient quantity  in pivot , 
            then it it either add or decrease

            this is a visualize docs in tablet, i nreallly dont fully understand this yet

















            
*/
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Ingredient::class);
    }
}
