<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;
    protected array $pivotOrderProducts;
    protected function mutateFormDataBeforeCreate(array $data): array //this execute before save
    {

        //this $data came from lifecycle filament will auto matically throw it to function adn we just 
        //catach it with $data so this parameter can be named anything aslong as its an array 
        //         $data = [
        //   'status' => true,
        //   'branch_id' => 1,
        //   'orderProducts' => [ //we get this from form repearter, its like the select::make('orderProduct')
                                    //its the same for status and branch
        //      ['product_id' => 3, 'quantity' => 2, 'price' => 120],
        //      ['product_id' => 5, 'quantity' => 1, 'price' => 80],
        //   ],
        // ];
        // store the pivot data select to cache
        $this->pivotOrderProducts = $data['orderProducts'] ?? [];

        //         $this->cachedProducts = [
        //   ['product_id' => 3, 'quantity' => 2, 'price' => 120],
        //   ['product_id' => 5, 'quantity' => 1, 'price' => 80],
        // ];


        // Remove from main pivot data from $data so it only has the order column not pivot, becuase it could cause
        //error like before 
        unset($data['orderProducts']);
        //return the clean data, status,branch_id , to let the order id exist first, that the pivot will use
        return $data;
    }

    protected function afterCreate(): void
    {
        // After creating the order, attach products with pivot data
        if (!empty($this->pivotOrderProducts)) {
            foreach ($this->pivotOrderProducts as $item) {
                $this->record->products()->attach($item['product_id'], [
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
