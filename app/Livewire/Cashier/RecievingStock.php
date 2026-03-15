<?php

namespace App\Livewire\Cashier;

use App\Models\AddIngredient;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RecievingStock extends Component
{


    protected function UserBranchId()
    // gets the branch that is the same as user, so that we know where a
    //  add_ingridient should show

    {

         //making a query -- dangerous 
        // this is a seruis problem becuase we are doing so many different query just to show the fucking 
        // add_inrgedient of a branch, it would be better either have a model method that can make this easier
        // or this whole think redone in a new and more efficient way, becuase as of now the only thing i can thinkg
        // of optimizing this is by making it into one query with join by model methods 

        $userId = Auth::user();
        //this show the branch of where the user is assigned too, only id
        // $branch = Branch::find($userId->branch_id);

        // making sure a function do only one thing, to avoid bugs
        return $userId->branch_id; 
    }
    function addIngredientHistory()
    {
        dd(AddIngredient::where('branch_id', $this->UserBranchId())->get());
    }
    public function render()
    {
       
        //this where are the data form add_to_product
        $addToIngredients = AddIngredient::where('branch_id',3)->latest()->first();

        // dd($addToProducts->ingredients);
        return view('livewire.cashier.receiving-stock', ['addToIngredients' => $addToIngredients]);
    }
}
