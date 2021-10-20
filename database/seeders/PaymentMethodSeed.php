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
            'amount' => 20
        ]);

        PaymentMethod::create([
            'description' => 'Trimestral',
            'amount' => 55
        ]);
    }
}
