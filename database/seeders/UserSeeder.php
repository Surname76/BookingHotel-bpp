<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@hotel.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_admin' => true,
            ],
        );

        User::updateOrCreate(
            ['email' => 'user@hotel.com'],
            [
                'name' => 'user',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_admin' => false,
            ],
        );
    }
}
