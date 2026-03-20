<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentOrdersWidget extends BaseWidget
{
    protected static ?int $sort = 5;

    protected static ?string $heading = '🧾  Recent Orders';

    protected int | string | array $columnSpan = [
        'md' => 1,
        'xl' => 1,
    ];

    protected  ?string $pollingInterval = '30s';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::query()
                    ->withTrashed()
                    ->with(['branch', 'products'])
                    ->latest()
            )

            ->columns([
                TextColumn::make('id')
                    ->label('#')
                    ->sortable()
                    ->alignCenter()
                    ->weight('bold'),

                TextColumn::make('branch.location')
                    ->label('Branch')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color('warning'),

                TextColumn::make('status')
                    ->label('Status')
                    ->alignCenter()
                    ->badge()
                    ->state(fn(Order $record): string => match (true) {
                        $record->trashed()     => 'Cancelled',
                        (bool) $record->status => 'Completed',
                        default                => 'Held',
                    })
                    ->color(fn(Order $record): string => match (true) {
                        $record->trashed()     => 'danger',
                        (bool) $record->status => 'success',
                        default                => 'warning',
                    }),

                TextColumn::make('order_total')
                    ->label('Total')
                    ->alignRight()
                    ->state(function (Order $record): string {
                        $total = $record->products
                            ->sum(fn($p) => $p->pivot->price * $p->pivot->quantity);
                        return '₱ ' . number_format($total, 2);
                    }),

                TextColumn::make('products_count')
                    ->label('Items')
                    ->alignCenter()
                    ->counts('products')
                    ->suffix(' item(s)'),

                TextColumn::make('created_at')
                    ->label('Date')
                    ->since()
                    ->sortable()
                    ->tooltip(fn(Order $record): string => $record->created_at->format('M d, Y g:i A')),
            ])

            ->filters([
                SelectFilter::make('branch')
                    ->relationship('branch', 'location')
                    ->label('Branch')
                    ->searchable()
                    ->preload(),

                Tables\Filters\Filter::make('completed')
                    ->label('Completed Only')
                    ->query(fn(Builder $q) => $q->where('status', true)),

                Tables\Filters\Filter::make('held')
                    ->label('Held Only')
                    ->query(fn(Builder $q) => $q->where('status', false)->whereNull('deleted_at')),

                Tables\Filters\Filter::make('cancelled')
                    ->label('Cancelled Only')
                    ->query(fn(Builder $q) => $q->withTrashed()->whereNotNull('deleted_at')),
            ])

            ->defaultSort('created_at', 'desc')
            ->paginated([10, 25])
            ->striped();
    }
}