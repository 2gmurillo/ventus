<?php

namespace App\Http\Requests;

use App\Constants\EquipmentRisks;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEquipmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['string', 'min:3', 'max:80'],
            'risk' => ['nullable', Rule::in(EquipmentRisks::toArray())],
            'maintenance' => [$this->dateRule(), 'date'],
            'calibration' => [$this->dateRule(), 'date'],
        ];
    }

    private function dateRule(): string
    {
        if ($this->request->get('risk')) {

            return 'required';
        }

        return 'nullable';
    }
}
