<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\Branch;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name'),
                TextInput::make('email'),
                TextInput::make('password'),
                Select::make('branch_id')
                    ->label('Assign Branch')
                    ->relationship('branch', 'location')
                    ->distinct()
                    ->disableOptionsWhenSelectedInSiblingRepeaterItems(),
                //this is what allow you to select multiple value

            ]);
    }
}
