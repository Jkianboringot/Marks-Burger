<?php

namespace App\Livewire\Cashier;

use App\Models\Ingredient;
use Livewire\Component;

class CurrentStock extends Component
{
    // this just show the ingredient stock



    public function render()
    {
        $ingredients=Ingredient::all();
        return view('livewire.cashier.current-stock',['ingredients'=>$ingredients]);
    }
}
