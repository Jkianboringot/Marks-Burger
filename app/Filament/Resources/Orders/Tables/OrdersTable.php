<?php

namespace App\Filament\Resources\Orders\Tables;

use App\Models\Order;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
// <<<<<<< HEAD
// =======
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\Summarizers\Sum;
// >>>>>>> playground
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                ,
                TextColumn::make('products.name')
                // =======
                //                 // TextColumn::make('user.name')
                //                 //     ->searchable(),
                //                 // TextColumn::make('product.name')
                //                 //     ->searchable(),
                //                 // TextColumn::make('price')
                //                 //     ->money()
                //                 //     //give the sum of each group and all of them
                //                 //     ->summarize(Sum::make()->money()->label('total')
                //                 //     )
                //                 //     ->sortable(),
                //                 // TextColumn::make('created_at')
                //                 //     ->dateTime()
                //                 //     ->sortable()
                //                 //     ->toggleable(isToggledHiddenByDefault: true),
                //                 // TextColumn::make('updated_at')
                //                 //     ->dateTime()
                //                 //     ->sortable()
                //                 //     ->toggleable(isToggledHiddenByDefault: true),
                //                 // TextColumn::make('deleted_at')
                //                 //     ->dateTime()
                //                 //     ->sortable()
                //                 //     ->toggleable(isToggledHiddenByDefault: true),
            ])
            // ->defaultGroup('product.name')  
            // grouping data in table
            //having this is better than calculating everyhint with sql on index
            // >>>>>>> playground

            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([

                //this hides tthe action button like edit nad marks as complete
                // pretty nice, anything inside it is hidden

                EditAction::make(),


                // ok this is just like the table toggle or checkboxcolumn no clue what is the
                //diffrence
                //ok requiresConfirmation can only be done here, not in tbale column which suck
                // Action::make("Mark as Completed")
                //     ->requiresConfirmation()
                //     ->icon(Heroicon::OutlinedCheckBadge)

                //     // hidden work if is_completed is true then it hides it, this can be good for inventory sytem
                //     // since i do this thing in my system,
                //     ->hidden(fn(Order $record) => $record->is_completed)
                //     ->action(fn(Order $record) => $record->update(['is_completed' => true]))
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),


                    //bulk action, making all order select to be mark as completed
                    // BulkAction::make('Makrs as Complete')
                    //     ->requiresConfirmation()
                    //     ->icon(Heroicon::OutlinedCheckBadge)

                    //     // hidden work if is_completed is true then it hides it, this can be good for inventory sytem
                    //     // since i do this thing in my system,
                    //     ->action(fn(Collection $records) => $records->each->update(['is_completed' => true]))
                    //     ->deselectRecordsAfterCompletion()

                ]),
            ]);
    }
}
