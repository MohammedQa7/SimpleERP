<?php

namespace App\Filament\Resources\SubscriptionPlans\Tables;

use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SubscriptionPlansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->reorderable('order')
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('prices.price')
                    ->money(),
                TextColumn::make('prices.currency')
                    ->label('Currencies')
                    ->searchable(),
                TextColumn::make('prices.interval')
                    ->label('Intervals')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'monthly' => 'info',
                        'annually' => 'success',
                    }),
                TextColumn::make('prices.stripe_product_id')
                    ->label('Stripe Product ID')
                    ->searchable(),
                TextColumn::make('prices.stripe_price_id')
                    ->label('Stripe Price ID')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}