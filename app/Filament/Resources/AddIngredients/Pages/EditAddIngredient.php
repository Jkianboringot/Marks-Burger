<?php

namespace App\Filament\Resources\AddIngredients\Pages;

use App\Filament\Resources\AddIngredients\AddIngredientResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAddIngredient extends EditRecord
{
    protected static string $resource = AddIngredientResource::class;
    protected array $pivotData;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['AddIngredient'] = $this->record->ingredients->map(function ($ingredient) {
            return [
                'ingredient_id' => $ingredient->id,
                'quantity' => $ingredient->pivot->quantity
            ];
        })->toArray();

        return $data;
    }



    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->pivotData = $data['AddIngredient'];

        unset($data['AddIngredient']);

        return $data;
    }



    protected function afterCreate()
    {
        if (!empty($this->pivotData)) {
            foreach ($this->pivotData as $item) {
                $this->record->ingredients()->attach($item['ingredient_id'], [
                    'quantity' => $item['quantity'],
                ]);
            }
        }
    }
}
