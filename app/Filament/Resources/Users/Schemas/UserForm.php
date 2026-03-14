<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\Branch;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Schema;
use Filament\Resources\Pages\EditRecord;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name'),
                TextInput::make('email'),
                TextInput::make('password')
                    ->required(fn($livewire) => $livewire instanceof CreateRecord)

                    // what this dehydrate does is , only send the password to model/db if it has value
                    // and filled is what deciede that if password has something its true so hydrate send it to model/db
                    // if not then dont send it , remeber all form are dehydrated just puting dehydrate change 
                    // that behavior by a condition
                    ->dehydrated(fn($state) => filled($state))

                    //just hash teh password before its dehydrated to model/db
                    ->dehydrateStateUsing(fn($state) => bcrypt($state)),
                //  ->visible(fn ($livewire)=>$livewire instanceof CreateRecord),
                Select::make('branch_id')
                    ->label('Assign Branch')
                    ->relationship('branch', 'location')
                    ->distinct()
                    ->disableOptionsWhenSelectedInSiblingRepeaterItems(),
                //this is what allow you to select multiple value

            ]);
    }
}
