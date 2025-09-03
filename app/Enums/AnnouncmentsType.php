<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum AnnouncmentsType: string implements HasLabel
{
    case EVENT = 'Event';
    case UPDATE = 'Update';
    case NEWS = 'News';
    case AD = 'Ad';

    static function toArray()
    {
        return collect(AnnouncmentsType::cases())->mapWithKeys(function ($value, $key) {
            return [
                $value->name => str_replace('_', ' ', $value->value),
            ];
        });
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::EVENT => 'Event',
            self::UPDATE => 'Update',
            self::NEWS => 'News',
            self::AD => 'Ad',
        };
    }

}