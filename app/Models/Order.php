<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{

    use SoftDeletes;
    public $guarded = ['id'];

    public function product(): BelongsTo{
        return $this->belongsTo(Product::class);
    }

     public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }


    // public function products()
    // {
    //     return $this->belongsToMany(Product::class, 'product_order')
    //     ->withPivot(['quantity', 'price']);
    // }
}
