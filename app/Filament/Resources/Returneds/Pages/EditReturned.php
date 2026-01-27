<?php

namespace App\Filament\Resources\Returneds\Pages;

use App\Filament\Resources\Returneds\ReturnedResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReturned extends EditRecord
{
    protected static string $resource = ReturnedResource::class;

    protected array $pivotData;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['returnedProduct'] = $this->record->products->map(function ($product) {
            return [
                'product_id' => $product->id,
                'price' => $product->price,
                'quantity' => $product->quantity,
            ];
        })->toArray();
        return $data;
    }

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

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
