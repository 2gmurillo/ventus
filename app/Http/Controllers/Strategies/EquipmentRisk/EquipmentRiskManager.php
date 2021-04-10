<?php

namespace App\Http\Controllers\Strategies\EquipmentRisk;

class EquipmentRiskManager
{
    /**
     * @var EquipmentRiskContract
     */
    private $behavior;

    public function __construct(EquipmentRiskContract $behavior)
    {
        $this->behavior = $behavior;
    }

    public function getNextMaintenance(string $maintenance): string
    {
        return $this->behavior->getNextMaintenance($maintenance);
    }
}
