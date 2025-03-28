<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Actions;
use App\Filament\Widgets\TestWidget;
use App\Filament\Resources\UserResource;
use App\Filament\Resources\UserResource\Widgets\PostCount;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PostCount::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            TestWidget::class,
        ];
    }
}
