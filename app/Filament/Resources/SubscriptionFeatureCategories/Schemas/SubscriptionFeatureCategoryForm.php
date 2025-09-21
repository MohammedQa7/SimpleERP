<?php

namespace App\Filament\Resources\SubscriptionFeatureCategories\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SubscriptionFeatureCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->columnSpanFull(),

                Section::make('Create Features')
                    ->columnSpanFull()
                    ->schema([
                        Repeater::make('features')
                            ->relationship('features')
                            ->columnSpanFull()
                            ->default([])
                            ->schema([
                                TextInput::make('name')
                                    ->label('Feature Name')
                                    ->required(),
                            ])
                    ]),

            ]);
    }
}