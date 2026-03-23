<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Enums\UserRole;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'manage posts']);
        Permission::create(['name' => 'verify authors']);

        // create roles and assign existing permissions
        $roleAdmin = Role::create(['name' => UserRole::ADMIN->value]);
        $roleAdmin->givePermissionTo(Permission::all());

        $roleAuthor = Role::create(['name' => UserRole::AUTHOR->value]);
        $roleAuthor->givePermissionTo(['manage posts']);

        $roleUser = Role::create(['name' => UserRole::USER->value]);
    }
}
