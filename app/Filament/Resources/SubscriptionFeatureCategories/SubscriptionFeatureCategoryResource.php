<?php

namespace App\Filament\Resources\SubscriptionFeatureCategories;

use App\Filament\Resources\SubscriptionFeatureCategories\Pages\CreateSubscriptionFeatureCategory;
use App\Filament\Resources\SubscriptionFeatureCategories\Pages\EditSubscriptionFeatureCategory;
use App\Filament\Resources\SubscriptionFeatureCategories\Pages\ListSubscriptionFeatureCategories;
use App\Filament\Resources\SubscriptionFeatureCategories\Schemas\SubscriptionFeatureCategoryForm;
use App\Filament\Resources\SubscriptionFeatureCategories\Tables\SubscriptionFeatureCategoriesTable;
use App\Filament\Resources\SubscriptionPlans\RelationManagers\FeaturesRelationManager;
use App\Models\SubscriptionFeatureCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;


class SubscriptionFeatureCategoryResource extends Resource
{
    protected static ?string $model = SubscriptionFeatureCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function getNavigationLabel(): string
    {
        return 'Feature Categories';
    }

    public static function form(Schema $schema): Schema
    {
        return SubscriptionFeatureCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SubscriptionFeatureCategoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
          
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSubscriptionFeatureCategories::route('/'),
            'create' => CreateSubscriptionFeatureCategory::route('/create'),
            'edit' => EditSubscriptionFeatureCategory::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withCount('features');
    }
}