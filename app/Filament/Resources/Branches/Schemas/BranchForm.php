<?php

namespace App\Filament\Resources\Branches\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BranchForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('location')
                    ->required(),
                Select::make('branch_type')
                    ->options(['main' => 'Main', 'sub' => 'Sub'])
                    ->default('sub')
                    ->required(),
            ]);
    }
}
