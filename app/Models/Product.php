<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\Guard;

class Product extends Model
{
    public $fillable = ['name','price','description'];
}
