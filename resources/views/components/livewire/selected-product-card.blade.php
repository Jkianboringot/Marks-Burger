@props(['product','quantity'])
<div class="card selection-box" >

    <div class="inner-selection">
        <img src="admin-lte\assets\img\ego-profile.jpg" alt="No Image">

    </div>
    <div class="selection-description">
        <h2 class="text-title">Name:<span class="text-variable">89
                {{ $product['product_id'] }}
                <!-- product_name
                     really need this shit to be eager loaded and hydrated what ever that means -->
            </span></h2>
        <!-- <h2 class="text-title">Product Name<span class="text-variable">89</span></h2> -->
        <input wire:model="quantity" type="number" min="1" max="999999">
        

<!-- ⚠️⚠️i dont know if i remove quantity in props will that not allow wire:model but i dont think it will -->

        @error('quantity')
        <small id="helpId" class="form-text text-danger">{{ $message }} </small>
        @enderror
        <h2 class="text-title">total:<span class="text-variable">

        <!-- this is not good but i will do this for now since my focus is on making it work
        nohing more, i dont care if its bad i only care if it works, once it does i will
        optimize it in the future -->
            {{ $product['price'] * 3}}
            </span></h2>
    </div>
</div>