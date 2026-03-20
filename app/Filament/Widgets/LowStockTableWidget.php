<?php

namespace App\Filament\Widgets;

use App\Models\Ingredient;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LowStockTableWidget extends BaseWidget
{
    protected static ?string $heading = 'Low Stock Alerts';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        // ── Compute low-stock IDs using the existing model accessor ───────
        //
        // Ingredient::ingredient_stock uses the formula:
        //   SUM(add_to_ingredient.quantity)  ← stock additions
        //   + returns()                       ← returned products restore stock
        //   - sold()                          ← sold products consume stock
        //
        // We load all ingredients once, evaluate each, and collect the IDs.
        // This is safe at food-stall scale (small ingredient catalog).
        // For larger datasets, consider caching or a dedicated stock table.
        //
        // Note: branch filter does NOT apply here because `ingredient_stock`
        // is a global accessor. `getBranchIngredientStockAttribute` depends on
        // Auth::user()->branch_id which is not reliable in an admin context.
        $lowStockIds = Ingredient::with('addIngredients')
            ->get()
            ->filter(fn (Ingredient $i) => $i->ingredient_stock <= $i->threshold)
            ->pluck('id');

        return $table
            ->query(
                Ingredient::query()
                    ->with('category')
                    ->whereIn('id', $lowStockIds)
                    ->orderBy('name')
            )
            ->columns([

                // ── Ingredient name ───────────────────────────────────────
                Tables\Columns\TextColumn::make('name')
                    ->label('Ingredient')
                    ->weight(FontWeight::SemiBold),

                // ── Category ──────────────────────────────────────────────
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->badge()
                    ->color('primary')
                    ->placeholder('—'),

                // ── Computed current stock ────────────────────────────────
                // Calls the existing ingredient_stock accessor on each record.
                // Color follows the same logic as .stock-row-low in the app CSS:
                //   stock <= 0   → danger (red)
                //   stock > 0    → warning (amber) — still low but not empty
                Tables\Columns\TextColumn::make('current_stock')
                    ->label('Current Stock')
                    ->getStateUsing(fn (Ingredient $record): int => $record->ingredient_stock)
                    ->color(fn (Ingredient $record): string => $record->ingredient_stock <= 0
                        ? 'danger'
                        : 'warning'
                    )
                    ->weight(FontWeight::Bold),

                // ── Threshold ─────────────────────────────────────────────
                Tables\Columns\TextColumn::make('threshold')
                    ->label('Min. Threshold')
                    ->color('gray'),

            ])
            ->emptyStateIcon('heroicon-o-check-circle')
            ->emptyStateHeading('All ingredients are well-stocked')
            ->emptyStateDescription('No ingredients are at or below their minimum threshold.')
            ->paginated(false)
            ->striped()
            ->extraAttributes(['class' => 'low-stock-table']);
    }
}