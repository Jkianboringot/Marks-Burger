<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected array $pivotData;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['ingredientProducts'] = $this->record->ingredients->map(function ($ingredient) {
            return [
                'ingredient_id' => $ingredient->id,
                'quantity' => $ingredient->quantity,
            ];
        })->toArray();
        return $data;
    }

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
