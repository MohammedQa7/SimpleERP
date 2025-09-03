<?php

namespace App\Filament\Resources\Announcements;

use App\Enums\AnnouncmentsType;
use App\Filament\Resources\Announcements\Pages\ManageAnnouncements;
use App\Models\Announcement;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class AnnouncementResource extends Resource
{
    protected static ?string $model = Announcement::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Announcements';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                SpatieMediaLibraryFileUpload::make('announcement-image')
                    ->label('Headline_Image')
                    ->collection('announcement-images')
                    ->imageEditor()
                    ->disk('public')
                    ->columnSpanFull(),
                TextInput::make('uuid')
                    ->label('UUID')
                    ->default(Str::uuid()->toString())
                    ->readOnly(),
                TextInput::make('title')
                    ->required()
                    ->autocapitalize(),
                RichEditor::make('content')
                    ->columnSpanFull(),
                TextInput::make('version'),
                Select::make('type')
                    ->options(AnnouncmentsType::class)
                    ->native(false)
                    ->searchable()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Announcements')
            ->columns([
                SpatieMediaLibraryImageColumn::make('announcement-image')->collection('announcement-images'),
                TextColumn::make('uuid')
                    ->label('UUID')
                    ->hidden()
                    ->searchable(),
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('version')
                    ->searchable(),
                TextColumn::make('type')
                    ->searchable(),
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
                EditAction::make(),
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
            'index' => ManageAnnouncements::route('/'),
        ];
    }
}