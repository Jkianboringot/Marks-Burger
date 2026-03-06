{{-- =====================================================================
     cashier-view.blade.php
     =====================================================================

     LIVEWIRE PROPERTIES  (public $... in your Livewire component class)
     ─────────────────────────────────────────────────────────────────────
       $products          → Collection  — all available products for the grid
       $productList       → Collection  — items currently in the cart
       $total             → int/float   — sum of (price × quantity) for all cart items
       $showPaymentModal  → bool        — controls payment modal visibility
       $customerPay       → string      — what the customer is handing over (built by numpad)
       $customerChange    → float       — $customerPay - $total

     LIVEWIRE METHODS  (public function ... in your Livewire component class)
     ─────────────────────────────────────────────────────────────────────
       addProduct($productId)       → add 1 of product to $productList (or increment qty)
       cancelOrder()                → clear $productList and reset $total
       holdOrder()                  → park order, clear cart (implement as you see fit)
       openPaymentModal()           → set $showPaymentModal = true
       closePaymentModal()          → set $showPaymentModal = false; reset $customerPay
       appendToPayment($digit)      → append digit/dot to $customerPay string; recalc $customerChange
       clearPayment()               → reset $customerPay = '0'; reset $customerChange
       completeOrder()              → save transaction, clear cart, close modal
       increment($productId)        → +1 qty on item in $productList; recalc $total
       decrement($productId)        → -1 qty (remove item if qty reaches 0); recalc $total
     =====================================================================
--}}

<div class="cashier-bg">
    @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
       @elseif ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {{-- ================================================================
         MAIN LAYOUT ROW
         ================================================================ --}}
    <div class="cashier-container">

        {{-- ────────────────────────────────────────────────────────────
             LEFT — PRODUCT GRID
             wire:click on each card calls addProduct()
             ──────────────────────────────────────────────────────────── --}}
        <div class="product-container">

            @forelse($products as $product)

            {{-- product-card renders a .product-box
                     It fires: wire:click="addProduct({{ $product->id }})" internally --}}
            <x-livewire.product-card :product="$product" />

            @empty
            <p style="color: var(--text-light); font-size: 0.9rem; margin: auto;">
                No products available.
            </p>
            @endforelse

        </div>


        {{-- ────────────────────────────────────────────────────────────
             RIGHT — CHECKOUT PANEL + ACTION BUTTONS
             ──────────────────────────────────────────────────────────── --}}
        <div class="right-panel">

            {{-- ── Checkout table ── --}}
            <div class="checkout-panel">

                <div class="checkout-header">Check Out</div>

                <div class="checkout-table-wrapper">
                    <table class="checkout-table">
                        <thead>
                            <tr>
                                <th style="text-align: left;">name</th>
                                <th>QTY</th>
                                <th>price</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- selected-product-card renders a <tr>
                                 It fires: wire:click="increment/decrement($product->id)" internally --}}
                            @foreach($productList as $product)
                            <x-livewire.selected-product-card :product="$product" />
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- METHOD: none needed — $total is a computed property --}}
                <div class="checkout-total">
                    <span>Total</span>
                    <span>{{ number_format($total ?? 0, 2) }}</span>
                </div>

            </div>

            {{-- ── Cancel / Hold ── --}}
            <div class="action-buttons-row">

                {{-- METHOD: cancelOrder() — clear cart, reset total --}}
                <button class="btn-cancel-order" wire:click="cancelOrder">
                    Cancel Order
                </button>

                {{-- METHOD: holdOrder() — park current cart --}}
                <button class="btn-hold-order" wire:click="holdOrder">
                    Hold Order
                </button>

            </div>

            {{-- ── Order / proceed to payment ── --}}
            {{-- METHOD: openPaymentModal() — set $showPaymentModal = true --}}
            <button class="btn-order-now" wire:click="save">
                Order
            </button>

        </div>

    </div>


    {{-- ================================================================
         PAYMENT MODAL
         Shown when $showPaymentModal === true
         ================================================================ --}}
    @if($showPaymentModal ?? false)
    <div class="payment-modal-overlay"
        wire:click.self="closePaymentModal"> {{-- METHOD: closePaymentModal() --}}

        <div class="payment-modal">

            {{-- ── Displays ── --}}
            <div class="payment-modal-header">

                <div class="payment-label-block">
                    <div class="payment-label">Input Customer Pay</div>
                    {{-- PROPERTY: $customerPay --}}
                    <div class="payment-display">
                        {{ number_format((float)($customerPay ?? 0), 2) }}
                    </div>
                </div>

                <div class="payment-label-block">
                    <div class="payment-label change-label">Customer Change</div>
                    {{-- PROPERTY: $customerChange = $customerPay - $total --}}
                    <div class="payment-display">
                        {{ number_format($customerChange ?? 0, 2) }}
                    </div>
                </div>

            </div>

            {{-- ── Numpad + actions ── --}}
            <div class="payment-body">

                {{-- Numpad: each button appends its value to $customerPay --}}
                <div class="numpad-grid">

                    @foreach([1,2,3,4,5,6,7,8,9] as $digit)
                    {{-- METHOD: appendToPayment('digit') --}}
                    <button class="numpad-btn"
                        wire:click="appendToPayment('{{ $digit }}')">
                        {{ $digit }}
                    </button>
                    @endforeach

                    {{-- Bottom row: 00 · 0 · dot --}}
                    <button class="numpad-btn"
                        wire:click="appendToPayment('00')">00</button>

                    <button class="numpad-btn numpad-zero"
                        wire:click="appendToPayment('0')">0</button>

                    <button class="numpad-btn"
                        wire:click="appendToPayment('.')">.</button>

                </div>

                {{-- Action column --}}
                <div class="payment-actions">

                    {{-- METHOD: clearPayment() — reset $customerPay to '0' --}}
                    <button class="btn-clear" wire:click="clearPayment">
                        Clear
                    </button>

                    {{-- METHOD: closePaymentModal() --}}
                    <button class="btn-cancel-pay" wire:click="closePaymentModal">
                        Cancel
                    </button>

                    {{-- METHOD: completeOrder() — save, clear cart, close modal --}}
                    <button class="btn-complete" wire:click="completeOrder">
                        Complete
                    </button>

                </div>

            </div>

        </div>
    </div>
    @endif


    {{-- Footer is rendered globally by app.blade.php — nothing needed here --}}

</div>