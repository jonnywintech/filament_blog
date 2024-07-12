<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Post;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class PieChart extends ChartWidget
{

    use InteractsWithPageFilters;

    protected static ?string $heading = 'Chart';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $start = $this->filters['start_date'] ?: '';
        $end = $this->filters['end_date'] ?: '';

        // Initialize labels and data arrays
        $labels = [];
        $data = [];

        // Convert start and end filters to Carbon instances
        $startDate = $start ? Carbon::parse($start) : null;
        $endDate = $end ? Carbon::parse($end) : null;

        // Query posts with optional date filters
        $postsQuery = Post::query();

        if ($startDate) {
            $postsQuery->where('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $postsQuery->where('created_at', '<=', $endDate);
        }

        $posts = $postsQuery->get()->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('F'); // Group posts by month
        });

        foreach ($posts as $key => $value) {
            $data[$key] = $value->count();
        }

        $labels = array_keys($data);
        $values = array_values($data);

        return [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    'data' => $values,
                    'backgroundColor' => ['#4CAF50', '#f44336', '#ff9800', '#3f51b5', '#9c27b0', '#00bcd4', '#ffeb3b', '#795548', '#673ab7', '#9e9e9e', '#2196f3', '#ff5722', '#8bc34a'],
                    'borderColor' => ['#4CAF50', '#f44336', '#ff9800', '#3f51b5', '#9c27b0', '#00bcd4', '#ffeb3b', '#795548', '#673ab7', '#9e9e9e', '#2196f3', '#ff5722', '#8bc34a'],
                    'hoverOffset' => 4
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
