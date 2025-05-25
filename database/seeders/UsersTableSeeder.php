<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Muhammed Salama',
            'email' => 'devmuhammedsalama@gmail.com',
            'password' => Hash::make('password'),
            'role' => UserRole::ADMIN->value,
        ]);

        // Normal users
        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
            'role' => UserRole::USER->value,
        ]);

        User::create([
            'name' => 'Michael Johnson',
            'email' => 'michael@example.com',
            'password' => Hash::make('password'),
            'role' => UserRole::USER->value,
        ]);
    }
}
