<?php

namespace App\Filament\Resources\PostResource\Widgets;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class BlogPostsChart extends ChartWidget
{
    use InteractsWithPageFilters;
    protected static ?string $heading = 'Blog Posts';

    protected static ?int $sort = -1;

    protected int | string | array $columnSpan = 'full';


    protected static bool $isLazy = false;

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
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
