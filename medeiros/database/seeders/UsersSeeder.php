<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@medeiros.com.br',
            'password' => Hash::make('123456'),
            'role' => 'admin',
            'telefone' => '(85) 3291-2233',
        ]);

        User::create([
            'name' => 'RH Medeiros',
            'email' => 'rh@medeiros.com.br',
            'password' => Hash::make('123456'),
            'role' => 'rh',
            'telefone' => '(85) 9 8166-0326',
        ]);

        User::create([
            'name' => 'Marketing Medeiros',
            'email' => 'marketing@medeiros.com.br',
            'password' => Hash::make('123456'),
            'role' => 'marketing',
            'telefone' => '(85) 9 8166-0326',
        ]);

        User::create([
            'name' => 'Cliente Teste',
            'email' => 'cliente@teste.com',
            'password' => Hash::make('123456'),
            'role' => 'client',
            'telefone' => '(85) 9 9999-9999',
        ]);
    }
}
