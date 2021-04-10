<?php

use App\Constants\EquipmentRisks;
use App\Http\Controllers\Strategies\EquipmentRisk\Behaviors\HighRiskBehavior;
use App\Http\Controllers\Strategies\EquipmentRisk\Behaviors\LowRiskBehavior;
use App\Http\Controllers\Strategies\EquipmentRisk\Behaviors\MediumRiskBehavior;

return [
    EquipmentRisks::HIGH => ['behavior' => HighRiskBehavior::class],
    EquipmentRisks::MEDIUM => ['behavior' => MediumRiskBehavior::class],
    EquipmentRisks::LOW => ['behavior' => LowRiskBehavior::class],
];
