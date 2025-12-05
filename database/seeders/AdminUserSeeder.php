<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@gestao.test'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('senha123'),
                'role' => User::ROLE_SUPER_ADMIN,
            ]
        );
    }
}




