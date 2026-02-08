<?php

namespace App\Models;

use App\Models\Pivots\ProductIngredient;
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
        return $this->belongsToMany(Product::class, 'product_ingredients')
        ->withPivot(['quantity']);
    }


    public function addIngredients(): BelongsToMany
    {
        return $this->belongsToMany(AddIngredient::class, 'add_to_ingredient')
            ->withPivot(['quantity']);
    }


  
        //i was missing hte where, i thougth of doing it by i dont really know what id to point to, thats why i ruled out doing where
        //becuase i just op to how relation like addIngredient work, but that is not possible since productOrder is not a relation
        //but $this->id solve that, since we are in Ingredient model we can do $this->id becuase that model has an automatic $this-id
        //that give you the id of an instance , and this i did not know , so maybe read about it, read more laravel docs, you need more 
        //knowledge in laravel to be able to create a more solid plan in the future





// // dd(ProductOrder::join('products','product_orders.product_id','=',"products.id")
// //         ->join('product_ingredients','products.id','=','product_ingredients.product_id')->sum('product_ingredients.quantity')
// // )
// // ;
//         // 2. product->ingredient_product
//             // -this is not good, everytime we add a new product it decrease in ingredient, this the job of order
//         // return Product::join('product_ingredients', 'products.id', '=', "product_ingredients.product_id")->sum('product_ingredients.quantity');



    public function returns(): int
    {

        return Returned::join('product_returns', 'returneds.id', '=', 'product_returns.returned_id')
            ->join('product_returns','product_ingredients.product_id','=','product_returns.product_id')
            ->where('product_ingredients.product_id','=',$this->id)->sum('product_returns.quantity');
    }

    public function ingredientStock(): int
    {
        return max(($this->addIngredients()->sum('add_to_ingredient.quantity') ?? 0)
            - $this->returns(),0);

// ($this->products()->sum('product_ingredients.quantity') ?? 0)
// this one work and decrease the ingredient that is only connected to product, but its wrong, because it decrease
// the ingredient everytime a product is created



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
