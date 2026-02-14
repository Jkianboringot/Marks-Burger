<?php

namespace App\Livewire\Cashier;

use App\Models\Order;
use Livewire\Component;
use Ramsey\Uuid\Type\Decimal;
use Ramsey\Uuid\Type\Integer;

class CashierView extends Component
{
    public Order $order;

    public array $productList;

    public  Decimal $price;

    public Integer $quantity;

    protected function rules(){
        
    }
    public function render()
    {
        return view('livewire.cashier.cashier-view');
    }
}
