<?php

namespace App\Filament\Resources\SubscriptionPlans\Schemas;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SubscriptionPlanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),

                TextInput::make('restrictions')
                    ->disabled()
                    ->placeholder('Will be available soon..')
                    ->nullable(),

                Toggle::make('highlight')
                    ->label('Highlight as the most (important , most popular , etc...)'),


                Section::make('Create Price Types')
                    ->columnSpanFull()
                    ->schema([
                        Repeater::make('prices')
                            ->relationship('prices')
                            ->columnSpanFull()
                            ->default([])
                            ->schema([
                                TextInput::make('price')
                                    ->hint('The Price Should Be In "cents"')
                                    ->required()
                                    ->numeric()
                                    ->default(0)
                                    ->prefix('$'),
                                TextInput::make('currency')
                                    ->required()
                                    ->default('usd'),
                                Select::make('interval')
                                    ->options([
                                        'monthly' => 'Monthly',
                                        'annually' => 'Annually',
                                    ])
                                    ->default('monthly')
                                    ->native(false),
                                TextInput::make('stripe_product_id')
                                    ->required(),
                                TextInput::make('stripe_price_id')
                                    ->required(),
                            ])
                    ]),
                // Textarea::make('restrictions')
                //     ->columnSpanFull(),
            ]);
    }
}