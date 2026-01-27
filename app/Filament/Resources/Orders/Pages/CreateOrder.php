<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected array $pivotData;

    protected function mutateFormDataBeforeCreate(array $data): array
    {

        $this->pivotData = $data['orderProducts'];
        // dd($data['orderProducts']);
        unset($data['orderProducts']);

        return $data;
    }

    protected function afterCreate()
    {

        if ($this->pivotData) {
            foreach ($this->pivotData as $pdata) {
                $this->record->products()->attach($pdata['product_id'], [
                    'price' => $pdata['price'],
                    'quantity' => $pdata['quantity'],   
                ]);
            }
        }
    }
}
