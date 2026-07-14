<?php

namespace App\Enums;


use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;


enum EmploymentType: string  implements HasLabel
{
    case FULL_TIME = 'Full Time';
    case PART_TIME = 'Part Time';
    case CONTRACT = 'Contract';
    case TEMPORARY = 'Temporary';

    public function getLabel(): string
    {
        return match ($this) {
            self::FULL_TIME => 'Full Time',
            self::PART_TIME => 'Part Time',
            self::CONTRACT => 'Contract',
            self::TEMPORARY => 'Temporary',
        };
    }

    // public static function options(): array
    // {
    //     return [
    //         self::RENTER->value => self::RENTER->getLabel(),
    //         self::VENDOR->value => self::VENDOR->getLabel(),
    //     ];
    // }


}




