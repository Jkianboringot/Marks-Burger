<?php

namespace App\Livewire\Cashier;

use App\Models\AddIngredient;
use Livewire\Component;

class RecievingStock extends Component
{

    function addIngredientHistory(){
            dd('fuck');
        // return AddIngredient::all();
        // this must show as a modal

    }
    public function render()
    {
        //this where are the data form add_to_product

        $addToIngredients=AddIngredient::latest()->first();

        // dd($addToProducts->ingredients);
        return view('livewire.cashier.receiving-stock',['addToIngredients'=>$addToIngredients]);
    }
}
