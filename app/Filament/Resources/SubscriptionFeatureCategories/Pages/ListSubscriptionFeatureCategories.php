<?php

namespace App\Filament\Resources\SubscriptionFeatureCategories\Pages;

use App\Filament\Resources\SubscriptionFeatureCategories\SubscriptionFeatureCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSubscriptionFeatureCategories extends ListRecords
{
    protected static string $resource = SubscriptionFeatureCategoryResource::class;
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Create Category'),
        ];
    }
}