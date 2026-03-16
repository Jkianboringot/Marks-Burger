@props(['productItem','key'])
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
         → qty++ on matching $productItem item; recalc $total

       decrement($productId)
         → qty-- on matching item
         → if qty reaches 0: remove item from $productItem
         → recalc $total
     =====================================================================
--}}

<tr>
  @php
  use App\Models\Product;
 
  @endphp








<!-- fuck optimization for now do it later, just fix it for now -->
  {{-- Product name --}}
  <td>{{ Product::find($productItem['product_id'])->name }}</td>
  {{-- QTY stepper --}}
  <td>
    <div class="qty-control">

      {{-- METHOD: decrement($product->id) --}}
      <button class="qty-btn"
        wire:click="decrement({{ $key }})"
        title="Remove one">
        &minus;
      </button>

      {{-- PROPERTY: $product->quantity --}}
      <span class="qty-value">{{$productItem['quantity'] }}</span>

      {{-- METHOD: increment($product->id) --}}
      <button class="qty-btn"
        wire:click="increment({{ $key  }})"
        title="Add one">
        &plus;
      </button>

    </div>
  </td>

  {{-- Unit price (display only — multiply in backend for line total) --}}
  <td>{{$productItem['quantity']*$productItem['price'] }}</td>

</tr>