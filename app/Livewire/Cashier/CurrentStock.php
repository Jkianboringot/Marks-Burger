<?php

namespace App\Livewire\Cashier;

use App\Models\Ingredient;
use Livewire\Component;
use Livewire\WithPagination;

class CurrentStock extends Component
{
    use WithPagination;
    // this just show the ingredient stock
    public  $search;

    public function lowStockNotification(){
        dd('current stock');
            // return Ingredint::stock() min something like this;
        // this must show as a modal 
    }

    public function render()
    {
        $search = trim($this->search);

        //what this 'when' does is ,if $search exist we do this callback, so it become a where with if statement
        //that $search has value
        $ingredients = Ingredient::when(
            $search,
            fn($query) => 
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "$search%");
                //make sure search is like that dont do %$search% becuas that break index
            })
        )

            ->orderBy('created_at', 'desc')
            ->simplePaginate(10);

        return view('livewire.cashier.current-stock',['ingredients'=>$ingredients]);
    }
}
