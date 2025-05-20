<?php

namespace App\Enums;

enum FolderApperanceStatus: string
{
    case PUBLIC = 'Public';
    case PRIVATE = 'Private';

    static function toArray()
    {
        return collect(FolderApperanceStatus::cases())->mapWithKeys(function ($value, $key) {
            return [
                $value->name => str_replace('_', ' ', $value->value),
            ];
        });
    }

}