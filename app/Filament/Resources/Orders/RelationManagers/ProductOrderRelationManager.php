<?php

namespace App\Filament\Resources\Orders\RelationManagers;

use App\Models\Product;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductOrderRelationManager extends RelationManager
{
    protected static string $relationship = 'ProductOrder';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([


                Select::make('product_id')
                    ->relationship('products', 'name')
                    ->reactive()
                    ->afterStateUpdated(
                        fn($state, callable $set) =>
                        $set('price', Product::find($state)?->price)
                    )
                    ->required(),


                TextInput::make('quantity')

                    ->numeric()
                    ->required(),

                TextInput::make('price')
                    ->disabled(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('product')
            ->columns([
                TextColumn::make('product.name')
                    ->searchable(),
                TextColumn::make('quantity'),
                TextColumn::make('price'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                AttachAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DetachAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
