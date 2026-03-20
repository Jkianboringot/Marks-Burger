<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RevenueChartWidget extends ChartWidget
{
    protected  ?string $heading    = 'Revenue & Orders — Last 7 Days';
    protected  ?string $maxHeight  = '300px';

    protected  int|string|array  $columnSpan = 'full';

    // Receives the branch filter value from Dashboard::filtersForm()
    public ?array $filters = null;

    protected function getData(): array
    {
        $branchId = $this->filters['branch_id'] ?? null;

        // Build one data point per day for the last 7 days
        $days = collect(range(6, 0))->map(function (int $offset) use ($branchId): array {
            $date = Carbon::today()->subDays($offset);

            // Revenue: SUM(price * qty) for completed orders on this date
            $revenue = DB::table('product_orders')
                ->join('orders', 'product_orders.order_id', '=', 'orders.id')
                ->where('orders.status', true)
                ->whereNull('orders.deleted_at')
                ->whereDate('orders.created_at', $date)
                ->when($branchId, fn ($q) => $q->where('orders.branch_id', $branchId))
                ->selectRaw('COALESCE(SUM(product_orders.price * product_orders.quantity), 0) as total')
                ->value('total') ?? 0;

            // Order count: distinct completed orders on this date
            $orderCount = DB::table('orders')
                ->where('status', true)
                ->whereNull('deleted_at')
                ->whereDate('created_at', $date)
                ->when($branchId, fn ($q) => $q->where('branch_id', $branchId))
                ->count();

            return [
                'label'    => $date->format('M d'),
                'revenue'  => (float) $revenue,
                'orders'   => $orderCount,
            ];
        });

        return [
            'datasets' => [
                // Left axis — Revenue (₱), orange fill line
                [
                    'label'                => 'Revenue (₱)',
                    'data'                 => $days->pluck('revenue')->toArray(),
                    'fill'                 => true,
                    'backgroundColor'      => 'rgba(255,128,0,0.10)',
                    'borderColor'          => 'rgba(255,128,0,0.90)',
                    'borderWidth'          => 2,
                    'tension'              => 0.45,
                    'pointBackgroundColor' => 'rgba(255,128,0,1)',
                    'pointRadius'          => 4,
                    'yAxisID'              => 'y',
                ],
                // Right axis — Order count, green dashed line
                [
                    'label'                => 'Orders',
                    'data'                 => $days->pluck('orders')->toArray(),
                    'fill'                 => false,
                    'borderColor'          => 'rgba(56,161,105,0.80)',
                    'borderWidth'          => 1.5,
                    'borderDash'           => [5, 4],
                    'tension'              => 0.45,
                    'pointBackgroundColor' => 'rgba(56,161,105,1)',
                    'pointRadius'          => 3,
                    'yAxisID'              => 'y1',
                ],
            ],
            'labels' => $days->pluck('label')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'interaction' => [
                'mode'      => 'index',
                'intersect' => false,
            ],
            'plugins' => [
                'legend' => [
                    'display'  => true,
                    'position' => 'top',
                ],
                'tooltip' => [
                    'callbacks' => [
                        // Note: JS callback strings are not natively supported in
                        // Filament's getOptions() array — format tooltips via
                        // custom JS if you need ₱ prefix on hover labels.
                    ],
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'position'    => 'left',
                    'title'       => [
                        'display' => true,
                        'text'    => 'Revenue (₱)',
                    ],
                ],
                'y1' => [
                    'beginAtZero' => true,
                    'position'    => 'right',
                    'title'       => [
                        'display' => true,
                        'text'    => 'Orders',
                    ],
                    'grid' => [
                        'drawOnChartArea' => false, // prevents grid line overlap
                    ],
                ],
            ],
        ];
    }
}