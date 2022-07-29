<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class AppPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permission1 = Permission::create(['name' => 'depot_unique']);
        $permission2 = Permission::create(['name' => 'multi_depot']);
        $permission3 = Permission::create(['name' => 'vente_comptoir']);
        $permission4 = Permission::create(['name' => 'transfert_stock']);
        $permission5 = Permission::create(['name' => 'facture_avoir']);
        $permission6 = Permission::create(['name' => 'all_perms']);

        $role1 = Role::create(['name' => 'vendeur']);
        $role1->givePermissionTo('depot_unique');
        $role1->givePermissionTo('vente_comptoir');

        $role2 = Role::create(['name' => 'magasinier']);
        $role2->givePermissionTo('depot_unique');
        $role2->givePermissionTo('transfert_stock');

        $role3 = Role::create(['name' => 'chef_equipe']);
        $role3->givePermissionTo('depot_unique');
        $role3->givePermissionTo('vente_comptoir');
        $role3->givePermissionTo('facture_avoir');

        $role4 = Role::create(['name' => 'comptable']);
        $role4->givePermissionTo('multi_depot');
        $role4->givePermissionTo('all_perms');
    }
}
