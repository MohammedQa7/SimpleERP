<?php

namespace App\Filament\Resources\Themes;

use App\Filament\Resources\Themes\Pages\ManageThemes;
use App\Models\Theme;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ThemeResource extends Resource
{
    protected static ?string $model = Theme::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Theme';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('css_file_name')
                    ->helperText('Please make sure it is the same css file name in the themes directory.')
                    ->required(),
                Textarea::make('description')
                    ->hint('(optional)')
                    ->columnSpanFull(),
                Repeater::make('color_palette')
                    ->schema([
                        ColorPicker::make('color_palette')
                    ])->columnSpanFull()
                    ->dehydrated(),
                Toggle::make('is_available')
                    ->default(true)
                    ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Theme')
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('css_file_name')
                    ->searchable(),
                IconColumn::make('is_available')
                    ->boolean(),
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
                EditAction::make()
                    ->mutateRecordDataUsing(function (array $data): array {
                        $data['color_palette'] = collect($data['color_palette'])->map(function ($state) {
                            return ['color_palette' => $state];
                        })->toArray();
                        return $data;
                    }),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageThemes::route('/'),
        ];
    }
}