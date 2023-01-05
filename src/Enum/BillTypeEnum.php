<?php

declare(strict_types=1);

namespace App\Enum;

enum BillTypeEnum: string
{
    case OTHER = 'other';

    public function getLabel(): string
    {
        return match($this)
        {
            self::OTHER => 'Inne',
        };
    }
}