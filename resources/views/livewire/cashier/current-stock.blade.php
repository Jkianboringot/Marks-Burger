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
            <button class="stock-header-btn" wire:click="lowStockNotification">
                <!-- // return Ingredint::stock() min something like this;
        // this must show as a modal -->

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

                    <!-- ok this works but its shit, but i will let it be for now, also i ahve no clue how i did this hahah
                fuck, my understanding of laravel is really still to low, like i needed gpt help just to know that
                i can use 'with' relation like that, i always thought it was just for eager loading, the more you know
                in the future i think i will just make a custome query fro it -->

                    @forelse($addIngredients as $addIngredient)

                    @foreach($addIngredient->ingredients as $ingredient)

                    <tr
                        class="{{ $ingredient->branch_ingredient_stock <= $ingredient->threshold ? 'stock-row-low' : '' }}">
                        <td>{{ $ingredient->name }}</td>
                        <td>{{ number_format($ingredient->threshold) }}</td>
                        <td>{{ $ingredient->category_id }}</td>

                        {{-- unit_quantity: add this column to your ingredients table + model if missing --}}
                        <td class="col-unit">{{ number_format($ingredient->unit_quantity ?? 0) }}</td>

                        <td>{{ number_format($ingredient->branch_ingredient_stock) }}</td>

                    </tr>

                    @endforeach
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
        <div class="mt-2">
            {{$addIngredients->links()}}
        </div>
    </div>
    {{-- Footer is rendered by app.blade.php layout — nothing needed here --}}
</div>