<?php

namespace App\Filament\Resources\IntegrationProviders\Pages;

use App\Filament\Resources\IntegrationProviders\IntegrationProvidersResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListIntegrationProviders extends ListRecords
{
    protected static string $resource = IntegrationProvidersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
