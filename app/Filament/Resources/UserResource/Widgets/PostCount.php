<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class PostCount extends BaseWidget
{
    public ?User $record;
    protected function getStats(): array
    {
        return [
            Stat::make('Number of posts', $this->record->posts()->count() ?? 0),
        ];
    }
}
