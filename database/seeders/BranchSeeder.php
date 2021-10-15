<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Branch::create([
            'name' => 'Gimnasio 1',
            'address' => 'Address 1'
        ]);

        Branch::create([
            'name' => 'Gimnasio 2',
            'address' => 'Address 2'
        ]);
    }
}
