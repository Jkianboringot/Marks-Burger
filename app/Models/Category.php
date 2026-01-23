<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
<<<<<<< HEAD
      protected $fillable = ['name'];

      public function ingredient(): HasMany{
        return $this->hasMany(Ingredient::class);
      }//one to many
=======
    public $guarded = ['id'];


    public function products(): HasMany{
        return $this->hasMany(Product::class);
    }
>>>>>>> playground
}
