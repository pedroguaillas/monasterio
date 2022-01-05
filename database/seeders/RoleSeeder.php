<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create(['name' => 'Administrador']);
        $role2 = Role::create(['name' => 'Contador']);
        $role3 = Role::create(['name' => 'Colaborador']);

        Permission::create(['name' => 'admin.home'])->assignRole($role1);
        Permission::create(['name' => 'admin.contabilidad'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.estadistica'])->assignRole($role1);
        Permission::create(['name' => 'admin.servicios'])->assignRole($role1);

        Permission::create(['name' => 'customers.index'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'customers.create'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'customers.store'])->syncRoles([$role1, $role2, $role3]);
    }
}
