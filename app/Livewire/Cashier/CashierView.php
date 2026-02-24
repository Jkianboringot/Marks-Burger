<?php

namespace App\Livewire\Cashier;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Queue\QueueManager;
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
            // 'quantity' => 'required|integer|min:1',
            'productList' => 'required'
        ];
    }

    public function mount()
    {
        $this->orders = new Order();
    }


    function addToList($id)
    {
        // $this->productList[$this->selectedProductId]['quantity'] += $this->quantity;
        // try this becuase i dont really get why the for each  
        $product = Product::find($id);

        // foreach ($this->productList as $key => $list) {
        //     if ($list['product_id'] == $id) {
        //         $this->productList[$key]['quantity']++;
        //     }
        // }
        array_push($this->productList, [
            'price' => $product->price,
            'product_id' => $id,
            // 'quantity' => $this->quantity
            //i can maybe just not put this here then later when attaching that is when i put it
        ]);
        // dd($this->productList);
    }




    public function save()
    {
        $this->validate();

        try {
            $this->orders->save();

            foreach ($this->productList as $product) {
                // we need to attach this to relation
                $this->products()->attach(
                    [$product['product_id']],
                    [
                        'price' => $product->price,
                        'quantity' => 3,
                    ]
                );
            }
        } catch (\Throwable $th) {
            $this->dispatch('done', error: 'Something went wrong' . $th->getMessage());
        }
    }

    public function render()
    {
        $products = Product::all();
        return view(
            'livewire.cashier.cashier-view',
            [
                'products' => $products
            ]
        );
    }
}
