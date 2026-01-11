<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario Admin Principal (tú)
        $admin = User::create([
            'name' => 'Adrian Vega',
            'email' => 'adrianvegat@gmail.com', // Cambia esto por tu email
            'password' => Hash::make('password'), // Cambia esto por una contraseña segura
            'email_verified_at' => now(),
            'bio' => 'Full Stack Developer apasionado por la tecnología, IA y robótica.',
            'website' => 'https://adrianvegat.dev',
            'github_username' => 'adrianVegaT',
        ]);

        $admin->assignRole('admin');
    }
}