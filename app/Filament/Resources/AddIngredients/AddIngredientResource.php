<?php

namespace App\Filament\Resources\AddIngredients;

use App\Filament\Resources\AddIngredients\Pages\CreateAddIngredient;
use App\Filament\Resources\AddIngredients\Pages\EditAddIngredient;
use App\Filament\Resources\AddIngredients\Pages\ListAddIngredients;
use App\Filament\Resources\AddIngredients\RelationManagers\AddIngredientsRelationManager;
use App\Filament\Resources\AddIngredients\Schemas\AddIngredientForm;
use App\Filament\Resources\AddIngredients\Tables\AddIngredientsTable;
use App\Models\AddIngredient;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AddIngredientResource extends Resource
{
    protected static ?string $model = AddIngredient::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'AddIngredient';

    public static function form(Schema $schema): Schema
    {
        return AddIngredientForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AddIngredientsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
         AddIngredientsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAddIngredients::route('/'),
            'create' => CreateAddIngredient::route('/create'),
            'edit' => EditAddIngredient::route('/{record}/edit'),
        ];
    }
}
