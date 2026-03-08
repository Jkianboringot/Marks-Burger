<?php

namespace App\Livewire\Cashier;

use App\Models\AddIngredient;
use Livewire\Component;

class RecievingStock extends Component
{
    public function render()
    {
        //this where are the data form add_to_product

        $addToIngredients=AddIngredient::latest()->first();

        // dd($addToProducts->ingredients);
        return view('livewire.cashier.receiving-stock',['addToIngredients'=>$addToIngredients]);
    }
}
