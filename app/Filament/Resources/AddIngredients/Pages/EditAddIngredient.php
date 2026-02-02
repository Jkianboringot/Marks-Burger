<?php

namespace App\Filament\Resources\AddIngredients\Pages;

use App\Filament\Resources\AddIngredients\AddIngredientResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAddIngredient extends EditRecord
{
    protected static string $resource = AddIngredientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
