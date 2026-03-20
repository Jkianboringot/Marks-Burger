<?php

namespace App\Filament\Widgets;

use App\Models\Branch;
use Filament\Widgets\ChartWidget;

class OrdersByBranchWidget extends ChartWidget
{
    protected static ?int $sort = 3;

    protected  ?string $heading = 'Orders by Branch';

    protected int | string | array $columnSpan = 'full';

    protected  ?string $pollingInterval = '60s';

    public ?string $filter = 'all';

    protected function getFilters(): ?array
    {
        return [
            'all'  => 'All Branches',
            'main' => 'Main Branches',
            'sub'  => 'Sub Branches',
        ];
    }

    protected function getData(): array
    {
        $query = Branch::withCount([
            'order as completed_count' => fn($q) => $q
                ->where('status', true)
                ->whereNull('deleted_at'),

            'order as held_count' => fn($q) => $q
                ->where('status', false)
                ->whereNull('deleted_at'),

            'order as cancelled_count' => fn($q) => $q
                ->withTrashed()
                ->whereNotNull('deleted_at'),
        ]);

        if ($this->filter !== 'all') {
            $query->where('branch_type', $this->filter);
        }

        $branches = $query->get();

        return [
            'datasets' => [
                [
                    'label'           => 'Completed',
                    'data'            => $branches->pluck('completed_count')->toArray(),
                    'backgroundColor' => '#FF8000',
                    'borderRadius'    => 6,
                ],
                [
                    'label'           => 'Held',
                    'data'            => $branches->pluck('held_count')->toArray(),
                    'backgroundColor' => '#FFAA4D',
                    'borderRadius'    => 6,
                ],
                [
                    'label'           => 'Cancelled',
                    'data'            => $branches->pluck('cancelled_count')->toArray(),
                    'backgroundColor' => '#e53e3e',
                    'borderRadius'    => 6,
                ],
            ],
            'labels' => $branches->pluck('location')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                    'labels'   => ['usePointStyle' => true],
                ],
            ],
            'scales' => [
                'x' => [
                    'stacked' => false,
                    'grid'    => ['display' => false],
                ],
                'y' => [
                    'beginAtZero' => true,
                    'ticks'       => ['precision' => 0],
                    'grid'        => ['color' => 'rgba(0,0,0,0.04)'],
                ],
            ],
        ];
    }
}