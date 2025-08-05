<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Administrador Sistema',
                'email' => 'admin@motomanager.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
                'sales_goal' => 50000.00,
            ],
            [
                'name' => 'João Silva - Vendedor',
                'email' => 'joao.vendedor@motomanager.com',
                'password' => Hash::make('password'),
                'role' => 'vendedor',
                'is_active' => true,
                'sales_goal' => 25000.00,
            ],
            [
                'name' => 'Maria Santos - Gerente',
                'email' => 'gerente@motomanager.com',
                'password' => Hash::make('password'),
                'role' => 'gerente',
                'is_active' => true,
                'sales_goal' => 40000.00,
            ],
            [
                'name' => 'Carlos Oliveira - Oficina',
                'email' => 'oficina@motomanager.com',
                'password' => Hash::make('password'),
                'role' => 'oficina',
                'is_active' => true,
                'sales_goal' => 0.00,
            ],
            [
                'name' => 'Ana Costa - Vendedora',
                'email' => 'ana.vendedora@motomanager.com',
                'password' => Hash::make('password'),
                'role' => 'vendedor',
                'is_active' => true,
                'sales_goal' => 30000.00,
            ],
            [
                'name' => 'Pedro Lima - Vendedor',
                'email' => 'pedro.vendedor@motomanager.com',
                'password' => Hash::make('password'),
                'role' => 'vendedor',
                'is_active' => true,
                'sales_goal' => 28000.00,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}


