<?php

namespace App\Models;

use App\Enums\ProductStatusEnum;
use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD
=======
use Illuminate\Database\Eloquent\Relations\BelongsTo;
>>>>>>> playground
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Sanctum\Guard;

class Product extends Model
{
<<<<<<< HEAD
    public $fillable = ['name','price'];
=======
    protected $fillable = ['name','unit_cost','description','status','category_id','is_active'];
>>>>>>> playground

protected $casts = ['status'=>ProductStatusEnum::class];

      public function orders()
    {
        return $this->belongsToMany(Order::class, 'product_order')
        ->withPivot(['quantity', 'price']);
    }

<<<<<<< HEAD
     public function returneds()
    {
        return $this->belongsToMany(Order::class, 'product_return')
        ->withPivot(['quantity', 'price']);
    }

     public function ingredients(): BelongsToMany{
        return $this->belongsToMany(Ingredient::class,'product_ingredient')
        ->withPivot(['price','quantity']);
    }//might cause error, i feel it
=======

    public function category(): BelongsTo{ //in filament it needs to be strict type, if or has a type in fucntion, if not it will break
      return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany{
      return $this->belongsToMany(Tag::class);
    }
>>>>>>> playground
}
