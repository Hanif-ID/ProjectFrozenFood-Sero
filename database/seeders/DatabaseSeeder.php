<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Akun contoh (password: "password"):
     *   admin@sero.test  -> admin
     *   vendor@sero.test -> vendor
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@sero.test'],
            ['name' => 'Admin Sero', 'password' => 'password', 'role' => User::ROLE_ADMIN, 'email_verified_at' => now()]
        );

        User::updateOrCreate(
            ['email' => 'vendor@sero.test'],
            ['name' => 'Vendor Contoh', 'password' => 'password', 'role' => User::ROLE_VENDOR, 'email_verified_at' => now()]
        );
    }
}
