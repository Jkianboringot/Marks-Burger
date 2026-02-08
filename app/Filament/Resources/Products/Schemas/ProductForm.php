<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Enums\ProductStatusEnum;
use App\Filament\Tables\CategoriesTable;
use App\Models\Ingredient;
use Filament\Forms\Components\ModalTableSelect;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ToggleColumn;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name'),
                TextInput::make('price')->label('price')
                    ->numeric()->step(0.01)->minValue(0)->required(),

                Repeater::make('ingredientProducts')
                    ->label('Ingredient')
                    ->schema([
                        Select::make('ingredient_id')
                            ->label('Ingredient')
                            ->options(Ingredient::pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->distinct()
                            ->disableOptionsWhenSelectedInSiblingRepeaterItems(),



                        TextInput::make('quantity')
                            ->numeric()
                            ->required()
                            ->default(1)
                            ->minValue(0.01)
                            ->step(0.01),


                    ])
                    ->columns(3)
                    ->defaultItems(0)
                    ->addActionLabel('Add Product')
                    ->reorderable(false)
                    ->collapsible()
                    ->collapsed(false),
                // ->itemLabel(fn (array $state): ?string => 
                //     Ingredient::find($state['product_id'] ?? null)?->name ?? 'New Product'
                // ),

                // TextInput::make('description'),


                // Select::make('status')->options(ProductStatusEnum::class)
                // ->required(),


                //one to many relation
                //similar to relation below but this time, its has a new table like component
                //instead of a dropdown, its good if you want to be minimial, but modern adn high tech at the same time

                //     ModalTableSelect::make('category_id')
                //     ->relationship('category','name')
                //     ->tableConfiguration(CategoriesTable::class)



                //      //one to many relation
                //     //the normal relation, with dropdown
                //     // Select::make('category_id')
                //     // ->relationship('category','name')
                // ->nullable()
                //                         //this category come ffrom product model method category, not the table




                // //many to many relation
                //     ,Select::make('tags')
                //     ->relationship('tags','name')
                //     ->multiple()//this is what allow you to select multiple value

            ]);
    }
}
