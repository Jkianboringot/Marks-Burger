<?php

namespace App\Filament\Resources\AddIngredients\Pages;

use App\Filament\Resources\AddIngredients\AddIngredientResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAddIngredient extends CreateRecord
{
    protected static string $resource = AddIngredientResource::class;
    protected array $pivotData;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->pivotData = $data['AddIngredient'];

        unset($data['AddIngredient']);

        return $data;
    }

    protected function afterCreate(){
        if(!empty($this->pivotData)){
            foreach($this->pivotData as $pData){
                $this->record->ingredients->attach($pData['ingredient_id'],[
                    'quantity'=>$pData['quantity']
                ]);
            }
        }
    }
}
