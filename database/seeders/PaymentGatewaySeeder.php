<?php

namespace Database\Seeders;

use App\Models\PaymentGateway;
use Illuminate\Database\Seeder;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentGateway::truncate();
        PaymentGateway::create([
            'name' => 'PlacetoPay',
            'image' => 'img/payment_gateways/placetopay.png'
        ]);
        PaymentGateway::create([
            'name' => 'PayPal',
            'image' => 'img/payment_gateways/paypal.jpg',
        ]);
    }
}
