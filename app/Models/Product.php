<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Sanctum\Guard;

class Product extends Model
{
    public $fillable = ['name','unit_cost','description','status','category_id'];


      public function orders()
    {
        return $this->belongsToMany(Order::class, 'product_order')
        ->withPivot(['quantity', 'price']);
    }


    public function category(): BelongsTo{ //in filament it needs to be strict type, if or has a type in fucntion, if not it will break
      return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany{
      return $this->belongsToMany(Tag::class);
    }
}
