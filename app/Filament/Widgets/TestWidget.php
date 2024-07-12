<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class TestWidget extends BaseWidget
{

    protected int | string | array $columnSpan = 'full';


    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('New Users', User::count())
            ->description('New users that have joined')
            ->descriptionIcon('heroicon-o-user', IconPosition::Before)
            ->chart([1,3,5,10,20,40])
            ->color('success')
        ];
    }
}
