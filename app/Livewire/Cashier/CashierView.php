<?php

namespace App\Livewire\Cashier;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Queue\QueueManager;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use PhpParser\Error;
use Ramsey\Uuid\Type\Decimal;
use Ramsey\Uuid\Type\Integer;

class CashierView extends Component
{
    public Order $orders;

    public array $productList = [];


    // public  Decimal $price;

    public  $quantity = 0;
    protected function rules()
    {
        return [
            // 'order.price' => 'required|numeric|min:1',
            'quantity' => 'required',
            'productList' => 'required',
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
            'quantity' => 1
            //i can maybe just not put this here then later when attaching that is when i put it
        ]);
        // dd($this->productList);D
    }

    public function cancelOrder()
    {
        session()->flash('success', 'Ordered Cancel');
        $this->reset();
    }

    public function decrement($id)
    {
        $this->productList[$id]['quantity']--; //the shorthand syntax of the buttom one
//        $this->productList[$id] = [
//     'quantity' => $this->quantity--
// ];
    }

    public function increment($id)
    {
        $this->productList[$id]['quantity']++;//the shorthand syntax of the buttom one

        // dd('add');
//    $this->productList[$id] = [
//     'quantity' => $this->quantity++
// ];
    }


    public function save()
    {
        $this->validate();
        //i dont now why this is not showing fuck this
        try {

            //making a query -- dangerous 
            //this is note for functions that is causing too much query
            //temporary for now, just to make sure that order->branch_id gets the assigned user->branch_id
            $user = Auth::user();


            $this->orders->branch_id = $user->branch_id;
            $this->orders->save();

            foreach ($this->productList as $product) {
                // we need to attach this to relation
                $this->orders->products()->attach(
                    $product['product_id'],
                    [
                        'price' => $product['price'],
                        'quantity' => $product["quantity"],
                    ]
                );
            }

            // $this->dispatch('done', success: 'Order complete');
            $this->reset();
            session()->flash('success', 'Order complete');
        } catch (\Throwable $th) {
            $this->dispatch('done', error: 'Something went wrong' . $th->getMessage());
            session()->flash('error', 'Something gone wrong' . $th);
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
