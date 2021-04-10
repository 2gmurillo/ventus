<?php

namespace App\Constants;

class EquipmentRisks
{
    public const HIGH = 'high';
    public const MEDIUM = 'medium';
    public const LOW = 'low';

    public static function toArray(): array
    {
        return [
            self::HIGH,
            self::MEDIUM,
            self::LOW,
        ];
    }
}
