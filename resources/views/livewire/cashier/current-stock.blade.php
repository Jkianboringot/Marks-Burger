{{-- =====================================================================
     receiving-stock.blade.php
     =====================================================================

     LIVEWIRE PROPERTIES
     ─────────────────────────────────────────────────────────────────────
       $addToProducts   → Collection — each record has a ->ingredients relationship
                          each ingredient: ->name, ->category_id, ->pivot->quantity

     LIVEWIRE METHODS
     ─────────────────────────────────────────────────────────────────────
       markAsReceived()
         → mark selected records as received (update DB status / timestamps)
         → refresh $addToProducts
         → show success feedback (flash or property flag)

       logout()
         → Auth::logout(), redirect to login
     =====================================================================
--}}

<div class="stock-page">

    <div class="stock-container">

        {{-- ── Header ── --}}
        <div class="stock-header">
            <span>Receive Ingredient</span>
        </div>

        {{-- ── Table ── --}}
        <div class="stock-card">
            <table class="stock-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse($addToProducts as $addToProduct)

                        {{-- One addToProduct can contain multiple ingredients --}}
                        @foreach($addToProduct->ingredients as $ingredient)
                        <tr>
                            <td>{{ $ingredient->name }}</td>

                            {{-- category_id: swap for $ingredient->category->name if
                                 you have the relationship loaded --}}
                            <td>{{ $ingredient->category_id }}</td>

                            {{-- pivot->quantity: set in your BelongsToMany pivot table --}}
                            <td>{{ number_format($ingredient->pivot->quantity) }}</td>
                        </tr>
                        @endforeach

                    @empty
                    <tr>
                        <td colspan="3"
                            style="text-align: center; color: var(--text-light);
                                   padding: 2rem; font-size: 0.85rem;">
                            No incoming stock records.
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- ── Received button
             METHOD: markAsReceived()
             ── --}}
        <button class="btn-received" wire:click="markAsReceived">
            Received
        </button>

    </div>
    {{-- Footer is rendered by app.blade.php layout — nothing needed here --}}

</div>