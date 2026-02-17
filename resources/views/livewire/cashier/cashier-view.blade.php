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
    @for ($i=0;$i<10;$i++)
        <x-product-card/>
    @endfor
        
    </div>


    <div class="selected-container">

     <!-- when this is only one product it just puts it in the center i dont want that, fix it later -->
    @for ($i=0;$i<3;$i++)
        <x-selected-product-card/>
    @endfor
        

    
      
       
    </div>
        <div class="order-button">
            <h1>fuck</h1>
        </div>


</div>