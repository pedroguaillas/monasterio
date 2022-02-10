<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Support\Facades\Hash;

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

        $role1 = Role::create(['name' => 'Jefe']);
        $role2 = Role::create(['name' => 'Contador']);
        $role3 = Role::create(['name' => 'Colaborador']);

        Permission::create(['name' => 'admin.home'])->assignRole($role1);
        Permission::create(['name' => 'admin.contabilidad'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.estadistica'])->assignRole($role1);
        Permission::create(['name' => 'admin.servicios'])->assignRole($role1);
        Permission::create(['name' => 'admin.usuarios'])->assignRole($role1);

        Permission::create(['name' => 'customers.index'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'customers.create'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'customers.store'])->syncRoles([$role1, $role2, $role3]);

        User::factory()->create([
            'name' => 'Cristhian Lomas',
            'user' => 'Cristhian',
            'email' => 'cris@gmail.com'
        ])->assignRole('Jefe');

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

        $customer = $zeus->customers()->create(['user_id' => 1, 'identification' => '1105167694', 'first_name' => 'Pedro', 'last_name' => 'Guaillas', 'gender' => 'masculino', 'alias' => 'Peter', 'date_of_birth' => '1994-03-05']);

        $zeus->payments()->create(['customer_id' => $customer->id, 'start_period' => '2021-01-10', 'end_period' => '2021-01-10', 'to_pay' => 1135.9])
            ->paymentitems()->create(['branch_id' => $zeus->id, 'description' => 'Ingreso enero', 'amount' => 1135.9]);

        $zeus->payments()->create(['customer_id' => $customer->id, 'start_period' => '2021-02-10', 'end_period' => '2021-02-10', 'to_pay' => 388.75])
            ->paymentitems()->create(['branch_id' => $zeus->id, 'description' => 'Ingreso febrero', 'amount' => 388.75]);

        $zeus->payments()->create(['customer_id' => $customer->id, 'start_period' => '2021-03-10', 'end_period' => '2021-03-10', 'to_pay' => 432.75])
            ->paymentitems()->create(['branch_id' => $zeus->id, 'description' => 'Ingreso marzo', 'amount' => 432.75]);

        $zeus->payments()->create(['customer_id' => $customer->id, 'start_period' => '2021-04-10', 'end_period' => '2021-04-10', 'to_pay' => 772.4])
            ->paymentitems()->create(['branch_id' => $zeus->id, 'description' => 'Ingreso abril', 'amount' => 772.4]);

        $zeus->payments()->create(['customer_id' => $customer->id, 'start_period' => '2021-05-10', 'end_period' => '2021-05-10', 'to_pay' => 364.8])
            ->paymentitems()->create(['branch_id' => $zeus->id, 'description' => 'Ingreso mayo', 'amount' => 364.8]);

        $zeus->payments()->create(['customer_id' => $customer->id, 'start_period' => '2021-06-10', 'end_period' => '2021-06-10', 'to_pay' => 674.4])
            ->paymentitems()->create(['branch_id' => $zeus->id, 'description' => 'Ingreso junio', 'amount' => 674.4]);

        $zeus->payments()->create(['customer_id' => $customer->id, 'start_period' => '2021-07-10', 'end_period' => '2021-07-10', 'to_pay' => 1040.64])
            ->paymentitems()->create(['branch_id' => $zeus->id, 'description' => 'Ingreso julio', 'amount' => 1040.64]);

        $zeus->payments()->create(['customer_id' => $customer->id, 'start_period' => '2021-08-10', 'end_period' => '2021-08-10', 'to_pay' => 1359.4])
            ->paymentitems()->create(['branch_id' => $zeus->id, 'description' => 'Ingreso agosto', 'amount' => 1359.4]);

        $zeus->payments()->create(['customer_id' => $customer->id, 'start_period' => '2021-09-10', 'end_period' => '2021-09-10', 'to_pay' => 1834.4])
            ->paymentitems()->create(['branch_id' => $zeus->id, 'description' => 'Ingreso septiembre', 'amount' => 1834.4]);

        $zeus->payments()->create(['customer_id' => $customer->id, 'start_period' => '2021-10-10', 'end_period' => '2021-10-10', 'to_pay' => 2583])
            ->paymentitems()->create(['branch_id' => $zeus->id, 'description' => 'Ingreso octubre', 'amount' => 2583]);

        $zeus->payments()->create(['customer_id' => $customer->id, 'start_period' => '2021-11-10', 'end_period' => '2021-11-10', 'to_pay' => 2694])
            ->paymentitems()->create(['branch_id' => $zeus->id, 'description' => 'Ingreso noviembre', 'amount' => 2694]);

        $zeus->payments()->create(['customer_id' => $customer->id, 'start_period' => '2021-12-10', 'end_period' => '2021-12-10', 'to_pay' => 1815])
            ->paymentitems()->create(['branch_id' => $zeus->id, 'description' => 'Ingreso diciembre', 'amount' => 1815]);

        $zeus->payments()->create(['customer_id' => $customer->id, 'start_period' => '2022-01-10', 'end_period' => '2022-01-10', 'to_pay' => 2545])
            ->paymentitems()->create(['branch_id' => $zeus->id, 'description' => 'Ingreso enero', 'amount' => 2545]);

        // $zeus->closures()->createMany([
        //     ['type' => 'diario', 'date' => '2021-01-10', 'entry' => 1135.9],
        //     ['type' => 'diario', 'date' => '2021-02-10', 'entry' => 388.75],
        //     ['type' => 'diario', 'date' => '2021-03-10', 'entry' => 432.75],
        //     ['type' => 'diario', 'date' => '2021-04-10', 'entry' => 772.4],
        //     ['type' => 'diario', 'date' => '2021-05-10', 'entry' => 364.8],
        //     ['type' => 'diario', 'date' => '2021-06-10', 'entry' => 674.4],
        //     ['type' => 'diario', 'date' => '2021-07-10', 'entry' => 1040.64],
        //     ['type' => 'diario', 'date' => '2021-08-10', 'entry' => 1359.4],
        //     ['type' => 'diario', 'date' => '2021-09-10', 'entry' => 1834.4],
        //     ['type' => 'diario', 'date' => '2021-10-10', 'entry' => 2583],
        //     ['type' => 'diario', 'date' => '2021-11-10', 'entry' => 2694],
        //     ['type' => 'diario', 'date' => '2021-12-10', 'entry' => 1815],
        //     ['type' => 'diario', 'date' => '2022-01-10', 'entry' => 2545]
        // ]);

        $monasterio = Branch::create([
            'name' => 'Monasterio',
            'address' => 'Address 2'
        ]);

        $monasterio->payments()->create(['customer_id' => $customer->id, 'start_period' => '2021-04-10', 'end_period' => '2021-04-10', 'to_pay' => 826])
            ->paymentitems()->create(['branch_id' => $monasterio->id, 'description' => 'Ingreso abril', 'amount' => 826]);

        $monasterio->payments()->create(['customer_id' => $customer->id, 'start_period' => '2021-05-10', 'end_period' => '2021-05-10', 'to_pay' => 590.10])
            ->paymentitems()->create(['branch_id' => $monasterio->id, 'description' => 'Ingreso mayo', 'amount' => 590.10]);

        $monasterio->payments()->create(['customer_id' => $customer->id, 'start_period' => '2021-06-10', 'end_period' => '2021-06-10', 'to_pay' => 566])
            ->paymentitems()->create(['branch_id' => $monasterio->id, 'description' => 'Ingreso junio', 'amount' => 566]);

        $monasterio->payments()->create(['customer_id' => $customer->id, 'start_period' => '2021-07-10', 'end_period' => '2021-07-10', 'to_pay' => 1799.65])
            ->paymentitems()->create(['branch_id' => $monasterio->id, 'description' => 'Ingreso julio', 'amount' => 1799.65]);

        $monasterio->payments()->create(['customer_id' => $customer->id, 'start_period' => '2021-08-10', 'end_period' => '2021-08-10', 'to_pay' => 1595])
            ->paymentitems()->create(['branch_id' => $monasterio->id, 'description' => 'Ingreso agosto', 'amount' => 1595]);

        $monasterio->payments()->create(['customer_id' => $customer->id, 'start_period' => '2021-09-10', 'end_period' => '2021-09-10', 'to_pay' => 1812])
            ->paymentitems()->create(['branch_id' => $monasterio->id, 'description' => 'Ingreso septiembre', 'amount' => 1812]);

        $monasterio->payments()->create(['customer_id' => $customer->id, 'start_period' => '2021-10-10', 'end_period' => '2021-10-10', 'to_pay' => 2333.20])
            ->paymentitems()->create(['branch_id' => $monasterio->id, 'description' => 'Ingreso octubre', 'amount' => 2333.20]);

        $monasterio->payments()->create(['customer_id' => $customer->id, 'start_period' => '2021-11-10', 'end_period' => '2021-11-10', 'to_pay' => 2428])
            ->paymentitems()->create(['branch_id' => $monasterio->id, 'description' => 'Ingreso noviembre', 'amount' => 2428]);

        $monasterio->payments()->create(['customer_id' => $customer->id, 'start_period' => '2021-12-10', 'end_period' => '2021-12-10', 'to_pay' => 1684])
            ->paymentitems()->create(['branch_id' => $monasterio->id, 'description' => 'Ingreso diciembre', 'amount' => 1684]);

        $zeus->payments()->create(['customer_id' => $customer->id, 'start_period' => '2022-01-10', 'end_period' => '2022-01-10', 'to_pay' => 2543])
            ->paymentitems()->create(['branch_id' => $monasterio->id, 'description' => 'Ingreso enero', 'amount' => 2543]);

        // $monasterio->closures()->createMany([
        //     ['type' => 'diario', 'date' => '2021-04-10', 'entry' => 826],
        //     ['type' => 'diario', 'date' => '2021-05-10', 'entry' => 590.10],
        //     ['type' => 'diario', 'date' => '2021-06-10', 'entry' => 566],
        //     ['type' => 'diario', 'date' => '2021-07-10', 'entry' => 1799.65],
        //     ['type' => 'diario', 'date' => '2021-08-10', 'entry' => 1595],
        //     ['type' => 'diario', 'date' => '2021-09-10', 'entry' => 1812],
        //     ['type' => 'diario', 'date' => '2021-10-10', 'entry' => 2333.20],
        //     ['type' => 'diario', 'date' => '2021-11-10', 'entry' => 2428],
        //     ['type' => 'diario', 'date' => '2021-12-10', 'entry' => 1684],
        //     ['type' => 'diario', 'date' => '2022-01-10', 'entry' => 2543]
        // ]);
    }
}
