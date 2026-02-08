<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected array $pivotData;

  
    protected function mutateFormDataBeforeCreate(array $data): array
    {

        $this->pivotData = $data['ingredientProducts'] ?? [];

        unset($data['ingredientProducts']);
        return $data;
    }


    protected function afterCreate()
    {

        if (!empty($this->pivotData)) {
            foreach ($this->pivotData as $pData) {
                $this->record->ingredients()->attach($pData['ingredient_id'], [
                    'quantity' => $pData['quantity'],
                ]);
            }
        }
    }
}
