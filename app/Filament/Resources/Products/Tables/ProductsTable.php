<?php

namespace App\Filament\Resources\Products\Tables;

use App\Enums\ProductStatusEnum;
use App\Filament\Resources\Categories\CategoryResource;
use App\Filament\Resources\Products\ProductResource;
use App\Models\Product;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
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
                TextColumn::make('name')

                    //make name column clickable, if click it will go edit route of product
                    ->url(fn(Product $record): string => ProductResource::getUrl('edit', ['record' => $record]))

                    ->sortable()->searchable(), //search by product name
                TextColumn::make('unit_cost')
                ->alignEnd()//can be use to change the alignment of item
                ->sortable(), //sort by column
                TextColumn::make('description')
                ->label('dexcription'),//can be use to cahgne the name of a column
                TextColumn::make('status')->badge(),

                    ToggleColumn::make('is_active'),//a togglable column to make something true or false



                TextColumn::make('category.name') //how to show relation one to many, no need to worry about lazy loading 
                //because its auto eager loaded, pretty nice

                //make category column clickable with relation, if click it will go edit route of product
                //will not work becuae category was made simple meaning it has no edit route
                // ->url(fn(Product $record): string=>CategoryResource::getUrl('edit',['record'=>$record->category]))

                ,

                TextColumn::make('tags.name')->badge(), //this is for many to many

                TextColumn::make('created_at')
                ->since() // human readable it show 3mins ago good for udpate, but heavy
                // ->date('d-m-Y')normal data show  19-01-2026
                ->sortable()
            ])->defaultSort('name') //full table sort

            ->filters([
                SelectFilter::make('category_id') //filter with relation
                    ->relationship('category', 'name'),

                SelectFilter::make(name: 'status') //filter with no relation
                    ->options(ProductStatusEnum::class),
                Filter::make('created_at') //normal columns
                    ->schema([
                        DatePicker::make('created_at')

                    ])

                // ->query(fn (Builder $query): Builder=>$query->where('is_featured',true))
            ], layout: FiltersLayout::AboveContent)
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
