<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{

    use SoftDeletes;
          protected $fillable = ['branch_id','status'];


    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_order')
        ->withPivot(['quantity', 'price']);
    }
}
