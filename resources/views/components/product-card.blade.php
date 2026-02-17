@props(['productName','price'])  
   
   <div class="card product-box">
        <div class="inner-product">

            <img src="admin-lte\assets\img\ego-profile.jpg" alt="No Image">
            <!-- <h1 class="inner-product-text">product_name</h1> -->

        </div>
        <div class="product-description">
            <h2 class="product-name text-title">{{$productName}}
            </h2>
            <h2 class=" text-title">Price:
               {{$price}}
            </h2>
        </div>
    </div>