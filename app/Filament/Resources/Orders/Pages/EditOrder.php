<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;
    protected array $pivotData;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {

        $this->pivotData = $data['orderProducts'];

        unset($data['orderProducts']);

        return $data;
    }

    protected function afterCreate()
    {

        if ($this->pivotData) {
            foreach ($this->pivotData as $pdata) {
                $this->order->products()->sync($pdata['product_id'], [
                    'price' => $pdata['price'],
                    'quantity' => $pdata['quantity']
                ]);
            }
        }
    }
}
