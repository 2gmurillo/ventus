<?php

namespace App\Http\Controllers\Strategies\EquipmentRisk\Behaviors;

use App\Http\Controllers\Strategies\EquipmentRisk\EquipmentRiskContract;
use Carbon\Carbon;

class LowRiskBehavior implements EquipmentRiskContract
{
    private const NEXT_MAINTENANCE_IN_DAYS = 365;

    public function getNextMaintenance(string $maintenance): string
    {
        $maintenance = Carbon::parse($maintenance);

        return $maintenance->addDays(self::NEXT_MAINTENANCE_IN_DAYS);
    }
}
