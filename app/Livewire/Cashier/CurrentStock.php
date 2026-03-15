<?php

namespace App\Livewire\Cashier;

use App\Models\AddIngredient;
use App\Models\Ingredient;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class CurrentStock extends Component
{
    use WithPagination;
    // this just show the ingredient stock
    public  $search;

    public function lowStockNotification()
    {
        dd('current stock');
        // return Ingredint::stock() min something like this;
        // this must show as a modal 
    }

    public function render()
    {
        $search = trim($this->search);

        //what this 'when' does is ,if $search exist we do this callback, so it become a where with if statement
        //that $search has value
        $addIngredients = AddIngredient::where('branch_id',Auth::user()->branch_id)->when(
            $search,
            fn($query) => 
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "$search%");
                //make sure search is like that dont do %$search% becuas that break index
            })
        )
            // ->join('add_to_ingredient','add_ingredient')
            ->with('ingredients')
            ->orderBy('created_at', 'desc')
            ->simplePaginate(10);
      
            // make a custome qeury for this, its too shit when tis like this, especially the ui part having 2 forlopp
                // we could reduce that by doing a custom join
            //    <!-- ok this works but its shit, but i will let it be for now, also i ahve no clue how i did this hahah
            //     fuck, my understanding of laravel is really still to low, like i needed gpt help just to know that
            //     i can use 'with' relation like that, i always thought it was just for eager loading, the more you know
            //     in the future i think i will just make a custome query fro it

        return view('livewire.cashier.current-stock', ['addIngredients' => $addIngredients]);
    }
}
