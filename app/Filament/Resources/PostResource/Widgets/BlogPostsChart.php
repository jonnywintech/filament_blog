<?php

namespace App\Filament\Resources\PostResource\Widgets;

use App\Models\Post;
use App\Models\User;
use Filament\Widgets\ChartWidget;

class BlogPostsChart extends ChartWidget
{
    protected static ?string $heading = 'Blog Posts';

    protected static ?int $sort = -1;

    protected int | string | array $columnSpan = 'full';


    protected static bool $isLazy = false;

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
