{{-- =====================================================================
     current-stock.blade.php
     =====================================================================

     LIVEWIRE PROPERTIES
     ─────────────────────────────────────────────────────────────────────
       $ingredients   → Collection — all ingredients (filtered by $search)
       $search        → string     — bound to search input via wire:model

     LIVEWIRE METHODS
     ─────────────────────────────────────────────────────────────────────
       (none required for this view — $search filters automatically via
        updatedSearch() or a computed property in your component)

       Optional extras you may want:
         addIngredient()   → open a modal / redirect to create form
         logout()          → Auth::logout() + redirect
     =====================================================================
--}}

<div class="stock-page">

    <div class="stock-container">

        {{-- ── Header bar ── --}}
        <div class="stock-header">
            <span>Ingredient</span>

            {{-- METHOD (optional): addIngredient() --}}
            <button class="stock-header-btn" wire:click="addIngredient">
                Notifications
            </button>
        </div>

        {{-- ── Search
             PROPERTY: $search
             Livewire re-renders the table every time $search changes.
             In your component:
               public $search = '';
               public function updatedSearch() { } // Livewire handles re-render automatically
             ── --}}
        <input
            type="text"
            class="stock-search"
            placeholder="Search..."
            wire:model.live.debounce.300ms="search" />
            <!-- //make this defer in the future ,but we will transition this to vue so upto you
             read livewire submitting form -->

        {{-- ── Table ── --}}
        <div class="stock-card">
            <table class="stock-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Threshold</th>
                        <th>Category</th>

                        {{-- col-unit is hidden on mobile via CSS (.col-unit { display: none }) --}}
                        <th class="col-unit">Unit Quantity</th>

                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ingredients as $ingredient)
                    <tr
                        {{-- Add stock-row-low class when stock is at or below threshold.
                             CSS colours name + stock columns red automatically. --}}
                        class="{{ $ingredient->ingredient_stock <= $ingredient->threshold ? 'stock-row-low' : '' }}">
                        <td>{{ $ingredient->name }}</td>
                        <td>{{ number_format($ingredient->threshold) }}</td>
                        <td>{{ $ingredient->category_id }}</td>

                        {{-- unit_quantity: add this column to your ingredients table + model if missing --}}
                        <td class="col-unit">{{ number_format($ingredient->unit_quantity ?? 0) }}</td>

                        <td>{{ number_format($ingredient->ingredient_stock) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5"
                            style="text-align: center; color: var(--text-light);
                                   padding: 2rem; font-size: 0.85rem;">
                            No ingredients found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{$ingredients->links()}}

    </div>
    {{-- Footer is rendered by app.blade.php layout — nothing needed here --}}
</div>