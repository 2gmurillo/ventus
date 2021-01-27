<?php

declare(strict_types=1);

namespace App\Factories\PaymentGateways;

use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

class PaymentGatewayFactory
{
    protected const PLACETOPAY = 1;

    public static function create(int $paymentGateway): PaymentGatewayInterface
    {
        switch ($paymentGateway) {
            case self::PLACETOPAY:
                return new PlacetoPay();
            default:
                throw ValidationException::withMessages([
                    Alert::error(__('The selected payment platform is not in the configuration'))
                ]);
        }
    }
}
