<?php

namespace App\Filament\Resources\Ingredients\Pages;

use App\Filament\Resources\Ingredients\IngredientResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditIngredient extends EditRecord
{
    protected static string $resource = IngredientResource::class;
    protected array $pivotData;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['ingredientBranch'] = $this->record->branches->map(fn ($p) =>[
          'location'=>$p->location,  
          'quantity'=>$p->quantity,  
        ]);

        return $data;
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {

        $this->pivotData = $data['ingredientBranch'] ?? [];

        unset($data['ingredientBranch']);

        return $data;
    }

    protected function afterCreate()
    {
        if (!empty($this->pivotData)) {
            foreach ($this->pivotData as $pData) {
                $this->record->branches()->attach($pData['branch_id'], [
                    'quantity' => $pData['quantity']
                ]);
            }
        }
    }
}
