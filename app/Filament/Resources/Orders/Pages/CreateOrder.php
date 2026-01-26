<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Temporarily store the products data
        $this->cachedOrderProducts = $data['orderProducts'] ?? [];
        
        // Remove from main data to avoid trying to insert into orders table
        unset($data['orderProducts']);
        
        return $data;
    }

    protected function afterCreate(): void
    {
        // After creating the order, attach products with pivot data
        if (!empty($this->cachedOrderProducts)) {
            foreach ($this->cachedOrderProducts as $item) {
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