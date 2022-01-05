<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'Cristhian Lomas',
            'user' => 'Cristhian',
            'email' => 'cris@gmail.com'
        ])->assignRole('Administrador');

        User::factory()->create([
            'name' => 'Contadora Lomas',
            'user' => 'Contadora',
            'email' => 'contador@gmail.com',
            'password' => Hash::make('contador'),
        ])->assignRole('Contador');

        User::factory()->create([
            'name' => 'Colaborador Lomas',
            'user' => 'Colaborado',
            'email' => 'colaborador@gmail.com',
            'password' => Hash::make('colaborador'),
        ])->assignRole('Colaborador');
    }
}
