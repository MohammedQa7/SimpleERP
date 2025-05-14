<?php

namespace App\Filament\Resources\IntegrationProviders\Pages;

use App\Filament\Resources\IntegrationProviders\IntegrationProvidersResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditIntegrationProviders extends EditRecord
{
    protected static string $resource = IntegrationProvidersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
