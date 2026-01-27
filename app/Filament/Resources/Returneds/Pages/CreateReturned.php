<?php

namespace App\Filament\Resources\Returneds\Pages;

use App\Filament\Resources\Returneds\ReturnedResource;
use Filament\Resources\Pages\CreateRecord;

class CreateReturned extends CreateRecord
{
    protected static string $resource = ReturnedResource::class;

    protected array $pivotData;

    protected function mutateFormDataBeforeCreate(array $data): array
    {

        $this->pivotData = $data['returnedProduct'] ?? [];

        unset($data['returnedProduct']);
        return $data;
    }


    protected function afterCreate()
    {

        if (!empty($this->pivotData)) {
            foreach ($this->pivotData as $pData) {
                $this->record->products()->attach($pData['product_id'], [
                    'price' => $pData['price'],
                    'quantity' => $pData['quantity'],
                ]);
            }
        }
    }
}
