<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Load existing products from pivot table into the form
        $data['orderProducts'] = $this->record->products->map(function ($product) {
            return [
                'product_id' => $product->id,
                'quantity' => $product->pivot->quantity,
                'price' => $product->pivot->price,
            ];
        })->toArray();

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Store products data temporarily
        $this->cachedOrderProducts = $data['orderProducts'] ?? [];
        
        // Remove from main data
        unset($data['orderProducts']);
        
        return $data;
    }

    protected function afterSave(): void
    {
        // Sync products - this will update the pivot table
        $syncData = [];
        
        foreach ($this->cachedOrderProducts as $item) {
            $syncData[$item['product_id']] = [
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ];
        }
        
        // sync() will remove products not in the array and add/update the ones that are
        $this->record->products()->sync($syncData);
    }
}