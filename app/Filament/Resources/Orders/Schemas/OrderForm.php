<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Models\Product;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)        // force the schema itself to single column
            ->components([

                // ── TOP: Branch selector ──────────────────────────────
                Section::make('Branch')
                    ->columnSpanFull()  // stretch full width
                    ->schema([
                        Select::make('branch_id')
                            ->label('Branch')
                            ->relationship('branch', 'location')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpanFull(),
                    ]),

                // ── BOTTOM: Order items repeater ──────────────────────
                Section::make('Order Items')
                    ->columnSpanFull()  // stretch full width
                    ->schema([
                        Repeater::make('orderProducts')
                            ->label('Products')
                            ->schema([
                                Select::make('product_id')
                                    ->label('Product')
                                    ->options(Product::pluck('name', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->distinct()
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, Set $set) {
                                        $product = Product::find($state);
                                        if ($product) {
                                            $set('price', $product->price);
                                        }
                                    }),
                                    //state is the input value btw
                                  
                                
                                TextInput::make('quantity')
                                    ->numeric()
                                    ->required()
                                    ->default(1)
                                    ->minValue(0.01)
                                    ->step(0.01),
                                
                                TextInput::make('price')
                                    ->numeric()
                                    ->required()
                                    ->minValue(0.01)
                                    ->step(0.01)
                                    ->prefix('₱'),
                            ])
                            ->columns(1)    // inside each card: stacked vertically
                            ->grid(2)       // cards displayed 2 per row
                            ->defaultItems(0)
                            ->addActionLabel('Add Product')
                            ->reorderable(false)
                            ->collapsible()
                            ->collapsed(false)
                            ->itemLabel(fn (array $state): ?string => 
                                Product::find($state['product_id'] ?? null)?->name ?? 'New Product'
                            ),
                    ]),
            ]);
    }
}