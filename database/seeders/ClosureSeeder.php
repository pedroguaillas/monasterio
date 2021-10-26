<?php

namespace Database\Seeders;

use App\Models\Closure;
use Illuminate\Database\Seeder;

class ClosureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Closure::factory(50)->create();
    }
}
