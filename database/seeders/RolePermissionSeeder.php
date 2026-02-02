<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void{
       Permission::query()->delete();
       Role::query()->delete(); 
       app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
       Permission::create(['name'=>'create offre']);
       Permission::create(['name'=>'modifier offre']);
       Permission::create(['name'=>'supprimer offre']);
       Permission::create(['name'=>'apply offre']);

       $recruteur = Role::create(['name'=>'recruteur']);
       $rechercheur = Role::create(['name'=>'rechercheur']);

       $recruteur->givePermissionTo([
        'create offre','modifier offre' , 'supprimer offre'
       ]);
       $rechercheur->givePermissionTo(['apply offre']);


    }
}
