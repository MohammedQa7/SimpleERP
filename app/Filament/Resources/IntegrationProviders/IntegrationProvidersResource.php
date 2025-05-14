<?php

namespace App\Filament\Resources\IntegrationProviders;

use App\Filament\Resources\IntegrationProviders\Pages\CreateIntegrationProviders;
use App\Filament\Resources\IntegrationProviders\Pages\EditIntegrationProviders;
use App\Filament\Resources\IntegrationProviders\Pages\ListIntegrationProviders;
use App\Filament\Resources\IntegrationProviders\Schemas\IntegrationProvidersForm;
use App\Filament\Resources\IntegrationProviders\Tables\IntegrationProvidersTable;
use App\Models\IntegrationProviders;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class IntegrationProvidersResource extends Resource
{
    protected static ?string $model = IntegrationProviders::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return IntegrationProvidersForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return IntegrationProvidersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListIntegrationProviders::route('/'),
            'create' => CreateIntegrationProviders::route('/create'),
            'edit' => EditIntegrationProviders::route('/{record}/edit'),
        ];
    }
}
