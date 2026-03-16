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
    public bool $showPaymentModal = false;
    public array $productList = [];

    public  string $customerPay = '0';
    // public  Decimal $price;

    public  string $customerChange = '0';
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

    public function total()
    {
        $total = (int) 0;
        foreach ($this->productList as $item) {
            $total += $item['quantity'] * $item['price'];
        }
        return $total;

        // this ofcourse have to be check later if its optimize not too confident on what
        // i build personal, since am focus on making it work for now, not making it 
        // production ready, two different things

        // return collect($$this->productList)->sum(fn($item) => $item['quantity'] * $item['price']);
        // ⚠️⚠️problem and solution
        //   two ways can be done, get all the quantity and price in one go,
        //   or we loop to it nad get the quantity and price then add it to var
    }



    public  function openPaymentModal()
    {
        if ($this->productList) {
            $this->showPaymentModal = true;
        }

        $this->dispatch('toast', message: 'No order', type: 'cancel');
    }

    public  function closePaymentModal()
    {
        $this->showPaymentModal = false;
    }

    protected function customerChange()
    {
        $this->customerChange = max((int)$this->customerPay - $this->total(), 0);
    }

    public function appendToPayment($num)
    {

        $this->customerPay .= $num;
        $this->customerChange();
    }


    public function backSpace()
    {
        // subtract the last part of a string, 0 is start and -1 is the very last char
        $this->customerPay = substr($this->customerPay, 0, -1);
        $this->customerChange();
    }




    public function completeOrder()
    {
        dd($this->customerPay);
    }

    public  function clearPayment()
    {
        $this->customerPay = '0';
    }

    public function cancelOrder()
    {
        $this->dispatch('toast', message: 'Order Cancelled', type: 'cancel');


        $this->reset();
    }

    public function decrement($id)
    {
        $this->productList[$id]['quantity']--; //the shorthand syntax of the buttom one

    }

    public function increment($id)
    {
        $this->productList[$id]['quantity']++; //the shorthand syntax of the buttom one

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
            $this->showPaymentModal = false;



            // unsure add hard code noti

            $this->dispatch('toast', message: 'Order completed!', type: 'success');
        } catch (\Throwable $th) {


            // unsure add hard code noti

            $this->dispatch('toast', message: 'Something went wrong: ' . $th->getMessage(), type: 'error');
        }
    }

    public function render()
    {
        $products = Product::all();
        return view(
            'livewire.cashier.cashier-view',
            [
                'products' => $products,
                'total' => $this->total()
            ]
        );
    }
}
