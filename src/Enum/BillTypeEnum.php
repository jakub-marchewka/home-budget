<?php

declare(strict_types=1);

namespace App\Enum;

enum BillTypeEnum: string
{
    case OTHER = 'other';
    case ELECTRICITY = 'electricity';
    case ASSOCIATION = 'association';
    case GAS = 'gas';
    case INTERNET = 'internet';

    public function getLabel(): string
    {
        return match($this)
        {
            self::ELECTRICITY => 'Rachunek za prąd',
            self::OTHER => 'Inne',
            self::ASSOCIATION => 'Wspólnota',
            self::GAS => 'Rachunek za gaz',
            self::INTERNET => 'Rachunek za internet',
        };
    }
}