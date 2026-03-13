<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected array $pivotData;

  
    // $data is being pass when createing, it is automatically pass to the function
    // and we just catch it using $data
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // the data pass in $data specifically the Reapter is givin a 
        // new address by $this->pivotDate
        $this->pivotData = $data['ingredientProducts'] ?? []; //else we give it empty becuase its type
        
        // remove the ingredientProduct or Reapter input because product
        //will not be create with it attach becuase filament
        unset($data['ingredientProducts']); 
        return $data;
    }


    protected function afterCreate()
    {

        //after its created we attach the data that we took from earlier,
        //this is the only way to do it in filament for special pivot
    
        if (!empty($this->pivotData)) {
            foreach ($this->pivotData as $pData) {
                $this->record->ingredients()->attach($pData['ingredient_id'], [
                    'quantity' => $pData['quantity'],
                ]);
            }
        }
    }
}
