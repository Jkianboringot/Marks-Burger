<?php

namespace App\Filament\Resources\Returneds\Pages;

use App\Filament\Resources\Returneds\ReturnedResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListReturneds extends ListRecords
{
    protected static string $resource = ReturnedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
