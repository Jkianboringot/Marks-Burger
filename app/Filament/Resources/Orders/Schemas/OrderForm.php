<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Models\Product;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ToggleColumn;
use function PHPUnit\Framework\callback;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Toggle::make('status')
                    ->required(),

                Select::make('branch_id')
                    ->relationship('branch', 'location')
                    ->required(),

                // ->multiple() allow select multiple

            ]);
    }
}
