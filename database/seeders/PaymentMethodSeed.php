<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentMethod::create([
            'description' => 'Mensual',
            'months' => 1,
            'amount' => 25
        ]);

        PaymentMethod::create([
            'description' => 'Trimestral',
            'months' => 3,
            'amount' => 55
        ]);
    }
}
