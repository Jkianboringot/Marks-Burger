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
        $this->showPaymentModal = true;
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
        $this->showPaymentModal = true;
    }

    public  function closePaymentModal()
    {
        $this->showPaymentModal = false;
    }

    protected function customerChange()
    {
        $this->customerChange = $this->total - (int)$this->customerPay;
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
        session()->flash('success', 'Ordered Cancel');
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
                'products' => $products,
                'total' => $this->total()
            ]
        );
    }
}
