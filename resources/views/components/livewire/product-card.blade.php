@props(['product'])  
   
  {{-- =====================================================================
     product-card.blade.php
     resources/views/components/livewire/product-card.blade.php
     =====================================================================

     PROPS
     ─────────────────────────────────────────────────────────────────────
       $product->id       int     — passed to addProduct()
       $product->name     string
       $product->price    float
       $product->image    string|null  — relative path stored in DB (storage/)

     METHOD FIRED
     ─────────────────────────────────────────────────────────────────────
       addProduct($productId)
         → If product already in $productList: increment qty
         → Otherwise: push new entry with qty = 1
         → Recalculate $total
     =====================================================================
--}}

<div class="product-box"
     wire:click="addToList({{ $product->id }})"
     title="{{ $product->name }}">

    {{-- Image area — gray bg shows when no image is set --}}
    <div class="inner-product">
        @if(!empty($product->image))
            <img src="{{ asset('storage/' . $product->image) }}"
                 alt="{{ $product->name }}"
                 loading="lazy">
        @endif
    </div>

    {{-- Name + price --}}
    <div class="product-description">
        <div class="product-name">{{ $product->name }}</div>
        <div class="product-price">{{ number_format($product->price, 2) }}</div>
    </div>

</div>