<?php

namespace App\Filament\Resources\Products\Tables;

use App\Enums\ProductStatusEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable()->searchable(), //search by product name
                TextColumn::make('unit_cost')->sortable(), //sort by column
                TextColumn::make('description'),
                TextColumn::make('status'),
                TextColumn::make('category.name') //how to show relation one to many, no need to worry about lazy loading 
                //because its auto eager loaded, pretty nice
                ,
                TextColumn::make('tags.name') //this is for many to many
            ])->defaultSort('name') //full table sort

            ->filters([
                SelectFilter::make('category_id') //filter with relation
                    ->relationship('category', 'name'),

                SelectFilter::make(name: 'status') //filter with no relation
                    ->options(ProductStatusEnum::class)

,
                Filter::make('created_at') //normal columns
                ->schema([
                    DatePicker::make('created_at')
                   
                ])

                // ->query(fn (Builder $query): Builder=>$query->where('is_featured',true))
                ],layout:FiltersLayout::AboveContent)
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
            ])
            // ->toolbarActions([
            //     BulkActionGroup::make([
            //         DeleteBulkAction::make(),
            //     ]),
            // ])//checkbox tool bar for multi delete
        ;
    }
}
