<?php

namespace App\Http\Controllers;

use App\Constants\EquipmentRisks;
use App\Http\Controllers\Strategies\EquipmentRisk\EquipmentRiskManager;
use App\Http\Requests\StoreEquipmentRequest;
use App\Models\Equipment;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EquipmentController extends Controller
{
    public function index(): View
    {
        return view('equipments.index', [
            'equipments' => Equipment::latest()->paginate(),
        ]);
    }

    public function create(): View
    {
        return view('equipments.create', [
            'risks' => EquipmentRisks::toArray(),
        ]);
    }

    public function store(StoreEquipmentRequest $request): RedirectResponse
    {
        $equipment = new Equipment();
        $equipment->name = $request->get('name');
        $equipment->risk = $request->get('risk');
        $equipment->maintenance = $request->get('maintenance');
        $equipment->calibration = $request->get('calibration');
        $equipment->next_maintenance = $request->get('maintenance')
            ? $this->setNextMaintenance($request->get('risk'), $request->get('maintenance'))
            : null;
        $equipment->save();

        return redirect()->route('equipments.index');
    }

    private function setNextMaintenance(string $risk, string $maintenance): string
    {
        $riskBehavior = config('risks.' . $risk);

        return (new EquipmentRiskManager(new $riskBehavior['behavior']()))
            ->getNextMaintenance($maintenance);
    }
}
