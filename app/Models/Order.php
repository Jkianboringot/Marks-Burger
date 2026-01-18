<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{

    use SoftDeletes;
    public $guarded = ['id'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_order')
        ->withPivot(['quantity', 'price']);
    }
}
