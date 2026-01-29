<?php

namespace App\Filament\Resources\Ingredients\Pages;

use App\Filament\Resources\Ingredients\IngredientResource;
use Filament\Resources\Pages\CreateRecord;

class CreateIngredient extends CreateRecord
{
    protected static string $resource = IngredientResource::class;

    protected array $pivotData;

    protected function mutateFormDataBeforeCreate(array $data): array
    {

        $this->pivotData=$data['ingredientBranch']??[];

        unset($data['ingredientBranch']);

        return $data;
    }

    protected function afterCreate(){
        if(!empty($this->pivotData)){
            foreach($this->pivotData as $pData){
                $this->record->branches()->attach($pData['branch_id'],[
                'quantity'=>$pData['quantity']]);
            }
        }
    }
}
