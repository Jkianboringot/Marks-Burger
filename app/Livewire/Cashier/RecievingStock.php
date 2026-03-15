<?php

namespace App\Livewire\Cashier;

use App\Models\AddIngredient;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RecievingStock extends Component
{

    function addIngredientHistory()
    {
        dd('fuck');
        // return AddIngredient::all();
        // this must show as a modal

    }
    public function render()
    {
        $userId = Auth::user();

        $b = Branch::find($userId->branch_id); //this show the branch of where the user is assigned too

        //this where are the data form add_to_product
        $addToIngredients = AddIngredient::where('branch_id',$b->id)->latest()->first();

        // dd($addToProducts->ingredients);
        return view('livewire.cashier.receiving-stock', ['addToIngredients' => $addToIngredients]);
    }
}
