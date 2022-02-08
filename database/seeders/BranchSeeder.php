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
        $zeus = Branch::create([
            'name' => 'Zeus',
            'address' => 'Av. Daniel León Borja, Riobamba'
        ]);

        $zeus->closures()->createMany([
            ['type' => 'diario', 'date' => '2021-01-10', 'entry' => 1135.9],
            ['type' => 'diario', 'date' => '2021-02-10', 'entry' => 388.75],
            ['type' => 'diario', 'date' => '2021-03-10', 'entry' => 432.75],
            ['type' => 'diario', 'date' => '2021-04-10', 'entry' => 772.4],
            ['type' => 'diario', 'date' => '2021-05-10', 'entry' => 364.8],
            ['type' => 'diario', 'date' => '2021-06-10', 'entry' => 674.4],
            ['type' => 'diario', 'date' => '2021-07-10', 'entry' => 1040.64],
            ['type' => 'diario', 'date' => '2021-08-10', 'entry' => 1359.4],
            ['type' => 'diario', 'date' => '2021-09-10', 'entry' => 1834.4],
            ['type' => 'diario', 'date' => '2021-10-10', 'entry' => 2583],
            ['type' => 'diario', 'date' => '2021-11-10', 'entry' => 2694],
            ['type' => 'diario', 'date' => '2021-12-10', 'entry' => 1815],
            ['type' => 'diario', 'date' => '2022-01-10', 'entry' => 2545]
        ]);

        $monasterio = Branch::create([
            'name' => 'Monasterio',
            'address' => 'Address 2'
        ]);

        $monasterio->closures()->createMany([
            ['type' => 'diario', 'date' => '2021-04-10', 'entry' => 826],
            ['type' => 'diario', 'date' => '2021-05-10', 'entry' => 590.10],
            ['type' => 'diario', 'date' => '2021-06-10', 'entry' => 566],
            ['type' => 'diario', 'date' => '2021-07-10', 'entry' => 1799.65],
            ['type' => 'diario', 'date' => '2021-08-10', 'entry' => 1595],
            ['type' => 'diario', 'date' => '2021-09-10', 'entry' => 1812],
            ['type' => 'diario', 'date' => '2021-10-10', 'entry' => 2333.20],
            ['type' => 'diario', 'date' => '2021-11-10', 'entry' => 2428],
            ['type' => 'diario', 'date' => '2021-12-10', 'entry' => 1684],
            ['type' => 'diario', 'date' => '2022-01-10', 'entry' => 2543]
        ]);
    }
}
