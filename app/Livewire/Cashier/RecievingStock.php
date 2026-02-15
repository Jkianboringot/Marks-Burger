<?php

namespace App\Livewire\Cashier;

use App\Models\AddIngredient;
use Livewire\Component;

class RecievingStock extends Component
{
    public function render()
    {
        //this where are the data form add_to_product

        $addToProducts=AddIngredient::all();
        return view('livewire.cashier.receiving-stock',['addToProducts'=>$addToProducts]);
    }
}
