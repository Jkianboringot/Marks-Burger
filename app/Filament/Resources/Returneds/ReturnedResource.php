<?php

namespace App\Filament\Resources\Returneds;

use App\Filament\Resources\Returneds\Pages\CreateReturned;
use App\Filament\Resources\Returneds\Pages\EditReturned;
use App\Filament\Resources\Returneds\Pages\ListReturneds;
use App\Filament\Resources\Returneds\Schemas\ReturnedForm;
use App\Filament\Resources\Returneds\Tables\ReturnedsTable;
use App\Models\Returned;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ReturnedResource extends Resource
{
    protected static ?string $model = Returned::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ReturnedForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ReturnedsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListReturneds::route('/'),
            'create' => CreateReturned::route('/create'),
            'edit' => EditReturned::route('/{record}/edit'),
        ];
    }
}
