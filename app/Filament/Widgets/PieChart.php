<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use Filament\Widgets\ChartWidget;

class PieChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';
    protected static ?int $sort = 3;

    protected function getData(): array
    {

        $labels = [];

        $data = [];

        $values = [];

        $posts = Post::all()->groupBy('created_at');

        foreach ($posts as $key => $value) {
            $new_key = \Carbon\Carbon::parse($key)->format('F');
            if (!isset($data[$new_key])) {
                $data[$new_key] = 0;
            }
            $data[$new_key] += $value->count();
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
