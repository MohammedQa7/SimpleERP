<?php
namespace App\Enums;

enum TenantSetupStep: string
{
    case DOMAIN_SETUP = 'domain_setup';
    case DATABASE_SETUP = 'database_setup';
    case ESSENTIAL_DATA = 'essential_data';
    case FINALIZING = 'finalizing';



    public function label(): string
    {
        return match ($this) {
            self::DOMAIN_SETUP => 'Configuring your domain',
            self::DATABASE_SETUP => 'Preparing your database',
            self::ESSENTIAL_DATA => 'Loading essential data',
            self::FINALIZING => 'Finalizing setup',

        };
    }

    public static function toArray(): array
    {
        return [
            ['text' => self::DOMAIN_SETUP->label()],
            ['text' => self::DATABASE_SETUP->label()],
            ['text' => self::ESSENTIAL_DATA->label()],
            ['text' => self::FINALIZING->label()],

        ];
    }
}