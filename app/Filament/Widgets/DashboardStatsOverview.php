<?php

namespace App\Filament\Widgets;

use App\Models\Ingredient;
use App\Models\Order;
use App\Models\Returned;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class DashboardStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected  ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        $totalRevenue = DB::table('product_orders')
            ->join('orders', 'product_orders.order_id', '=', 'orders.id')
            ->where('orders.status', true)
            ->whereNull('orders.deleted_at')
            ->selectRaw('SUM(product_orders.price * product_orders.quantity) as total')
            ->value('total') ?? 0;

        $todayRevenue = DB::table('product_orders')
            ->join('orders', 'product_orders.order_id', '=', 'orders.id')
            ->where('orders.status', true)
            ->whereNull('orders.deleted_at')
            ->whereDate('orders.created_at', today())
            ->selectRaw('SUM(product_orders.price * product_orders.quantity) as total')
            ->value('total') ?? 0;

        $completedOrders = Order::where('status', true)->count();

        $totalReturns = Returned::count();

        $lowStockCount = Ingredient::all()
            ->filter(fn(Ingredient $ingredient) => $ingredient->ingredient_stock <= $ingredient->threshold)
            ->count();

        return [
            Stat::make('Completed Orders', number_format($completedOrders))
                ->description('Total fulfilled orders')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('success'),

            Stat::make('Total Revenue', '₱ ' . number_format($totalRevenue, 2))
                ->description('Today: ₱ ' . number_format($todayRevenue, 2))
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('warning'),

            Stat::make('Total Returns', number_format($totalReturns))
                ->description('Returned transactions')
                ->descriptionIcon('heroicon-m-arrow-uturn-left')
                ->color('danger'),

            Stat::make('Low Stock Alerts', $lowStockCount)
                ->description($lowStockCount > 0 ? 'Ingredients below threshold' : 'All stock levels OK')
                ->descriptionIcon($lowStockCount > 0 ? 'heroicon-m-exclamation-triangle' : 'heroicon-m-check-circle')
                ->color($lowStockCount > 0 ? 'danger' : 'success'),
        ];
    }
}