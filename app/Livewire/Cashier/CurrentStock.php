<?php

namespace App\Livewire\Cashier;

use App\Models\Ingredient;
use Livewire\Component;
use Livewire\WithPagination;

class CurrentStock extends Component
{
    use WithPagination;
    // this just show the ingredient stock



    public function render()
    {
        // simplePaginate(10)
        $ingredients=Ingredient::simplePaginate(40);
        return view('livewire.cashier.current-stock',['ingredients'=>$ingredients]);
    }
}
