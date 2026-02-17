<?php

namespace App\Livewire\Cashier;

use App\Models\Order;
use App\Models\Product;
use Livewire\Component;
use PhpParser\Error;
use Ramsey\Uuid\Type\Decimal;
use Ramsey\Uuid\Type\Integer;

class CashierView extends Component
{
    public Order $orders;

    public array $productList;

    // public  Decimal $price;

    public Integer $quantity;

    protected function rules()
    {
        return [
            'order.price' => 'required|numeric|min:1',
            'quantity' => 'required|integer|min:1',
            'productList' => 'required'
        ];
    }


    public function mount()
    {
        $this->orders = new Order();
    }

    public function save()
    {
        $this->validate();

        try {
            $this->orders->save();

            foreach ($this->productList as $product) {
                // we need to attach this to relation
                $this->products()->attach([$product['product_id']],
                    [
                        'price' => $this->price,
                        'quantity' => $this->quantity,
                    ]
                );
            }
        } catch (\Throwable $th) {
            $this->dispatch('done', error: 'Something went wrong' . $th->getMessage());
        }
    }

    public function render()
    {
        $products=Product::all();
        return view('livewire.cashier.cashier-view',['products'=>$products]);
    }
}
