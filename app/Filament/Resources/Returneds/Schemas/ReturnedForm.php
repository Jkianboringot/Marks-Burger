<?php

namespace App\Filament\Resources\Returneds\Schemas;

use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class ReturnedForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('order_id')
                    ->relationship('order', 'id')
                    ->required(),
                Select::make('branch_id')
                    ->relationship('branch', 'id')
                    ->required(),
            ]);
    }
}
