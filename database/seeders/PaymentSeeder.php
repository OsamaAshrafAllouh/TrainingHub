<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $paymentMethods = [
            'Credit Card',
            'Debit Card',
            'PayPal',
            'Apple Pay',
            'Google Pay',
            'Bank Transfer',
            'Cash',
            'Cryptocurrency',
            'Venmo',
            'Stripe',
            'Square',
            'Amazon Pay'
        ];

        foreach ($paymentMethods as $method) {
            Payment::create(['name' => $method]);
        }
    }
}
