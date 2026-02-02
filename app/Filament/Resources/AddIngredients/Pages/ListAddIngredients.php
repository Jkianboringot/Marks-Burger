<?php

namespace App\Filament\Resources\AddIngredients\Pages;

use App\Filament\Resources\AddIngredients\AddIngredientResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAddIngredients extends ListRecords
{
    protected static string $resource = AddIngredientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
