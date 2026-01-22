<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
      protected $fillable = ['name','threshold','category_id','unit_id','unit_quantity'];
    
}
