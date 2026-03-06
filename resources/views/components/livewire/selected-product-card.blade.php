@props(['product','quantity'])
{{-- =====================================================================
     selected-product-card.blade.php
     resources/views/components/livewire/selected-product-card.blade.php
     =====================================================================

     Renders as a <tr> — parent template must wrap @foreach in a <tbody>

     PROPS
     ─────────────────────────────────────────────────────────────────────
       $product->id        int
       $product->name      string
       $product->price     float    — unit price (line total = price × qty)
       $product->quantity  int      — current quantity in cart

     METHODS FIRED
     ─────────────────────────────────────────────────────────────────────
       increment($productId)
         → qty++ on matching $productList item; recalc $total

       decrement($productId)
         → qty-- on matching item
         → if qty reaches 0: remove item from $productList
         → recalc $total
     =====================================================================
--}}

<tr>

    {{-- Product name --}}
    <td>{{ $product['product_id'] }}</td>

    {{-- QTY stepper --}}
    <td>
        <div class="qty-control">

            {{-- METHOD: decrement($product->id) --}}
            <button class="qty-btn"
                    wire:click="decrement({{ $product['product_id'] }})"
                    title="Remove one">
                &minus;
            </button>

            {{-- PROPERTY: $product->quantity --}}
            <span class="qty-value">{{ $product['quantity'] }}</span>

            {{-- METHOD: increment($product->id) --}}
            <button class="qty-btn"
                    wire:click="increment({{ $product['product_id'] }})"
                    title="Add one">
                &plus;
            </button>

        </div>
    </td>

    {{-- Unit price (display only — multiply in backend for line total) --}}
    <td>{{ number_format($product['price'], 2) }}</td>

</tr>