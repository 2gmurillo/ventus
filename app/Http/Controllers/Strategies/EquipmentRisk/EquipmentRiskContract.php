<?php

namespace App\Http\Controllers\Strategies\EquipmentRisk;

interface EquipmentRiskContract
{
    public function getNextMaintenance(string $maintenance): string;
}
