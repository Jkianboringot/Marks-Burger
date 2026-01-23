<?php

namespace App\Filament\Resources\Returneds\Pages;

use App\Filament\Resources\Returneds\ReturnedResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditReturned extends EditRecord
{
    protected static string $resource = ReturnedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
