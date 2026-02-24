<div class="cashier-container">
    <!-- class="cashier-container" -->

    <!-- <div class="total-container"> -->


    <!-- 
    i really need to improve this , its just devs everywhere hahaha, its the only thing i 
    kow how to work without ai , bcause am pretty sure you dont just spam devs here-->
    <!-- <div>
            <h1>Total
            </h1>
        </div>
        <div class="total">
            <h3 >total_variable</h3>
                
        </div>
    </div> -->


    <div class="product-container">

        <!-- when this is only one product it just puts it in the center i dont want that, fix it later -->
        @foreach($products as $product)
        <x-livewire.product-card
            :product="$product"
          />

        <!-- ok am dumb fuck i got too impatient and let ai do this one -->
        @endforeach

    </div>


    <div class="selected-container">

        @foreach($productList as $product)
        <x-livewire.selected-product-card
            :product="$product"
         />

         <!-- we never even go inside the selected-product-card component -->

        <!-- ok am dumb fuck i got too impatient and let ai do this one -->
        @endforeach





    </div>
    <div class="order-button">

        <form wire:click="save">
            <h1>Order</h1>
        </form>
    </div>


</div>