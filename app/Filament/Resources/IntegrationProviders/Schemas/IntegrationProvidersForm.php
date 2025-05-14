<?php

namespace App\Filament\Resources\IntegrationProviders\Schemas;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class IntegrationProvidersForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('key')
                    ->helperText('IMPORTANT: THIS KEY MUST EXACTLY MATCH THE ONE USED IN THE BACKEND.')
                    ->required(),
                TextInput::make('folder_name')
                ->label('Folder name')
                    ->helperText('IMPORTANT: THIS KEY MUST EXACTLY MATCH THE ONE USED IN THE FRONTEND (Integration Folder -> Provider -> the actual name).')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                Checkbox::make('available')
                    ->default(1),

                SpatieMediaLibraryFileUpload::make('provider-icon')
                    ->label('Provider Icon')
                    ->collection('provider-icon')
                    ->imageEditor()
                    ->disk('public')
                    ->columnSpanFull(),
            ]);
    }
}