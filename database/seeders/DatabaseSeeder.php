<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class,
        ]);

        $admin = User::create([
            User::COL_NAME => 'Admin User',
            User::COL_EMAIL => 'admin@example.com',
            User::COL_PASSWORD => bcrypt('password'),
            User::COL_EMAIL_VERIFIED_AT => now(),
            User::COL_IS_VERIFIED_BY_ADMIN => true,
            User::COL_ADMIN_VERIFIED_AT => now(),
        ]);
        $admin->assignRole(\App\Enums\UserRole::ADMIN->value);

        $author = User::create([
            User::COL_NAME => 'Author User',
            User::COL_EMAIL => 'author@example.com',
            User::COL_PASSWORD => bcrypt('password'),
            User::COL_EMAIL_VERIFIED_AT => now(),
            User::COL_IS_VERIFIED_BY_ADMIN => true,
            User::COL_ADMIN_VERIFIED_AT => now(),
        ]);
        $author->assignRole(\App\Enums\UserRole::AUTHOR->value);

        $this->call([
            PostSeeder::class,
        ]);
    }
}
