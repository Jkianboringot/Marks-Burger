<?php

namespace App\Filament\Resources\AddIngredients\Pages;

use App\Filament\Resources\AddIngredients\AddIngredientResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAddIngredient extends CreateRecord
{
    protected static string $resource = AddIngredientResource::class;
    protected array $pivotData;
    
}
