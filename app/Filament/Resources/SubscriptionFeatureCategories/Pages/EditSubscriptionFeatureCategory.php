<?php

namespace App\Filament\Resources\SubscriptionFeatureCategories\Pages;

use App\Filament\Resources\SubscriptionFeatureCategories\SubscriptionFeatureCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSubscriptionFeatureCategory extends EditRecord
{
    protected static string $resource = SubscriptionFeatureCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
