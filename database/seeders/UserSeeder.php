<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        $admin = User::firstOrCreate([
            'email' => 'admin@educapp.com'
        ], [
            'name' => 'Administrador Sistema',
            'password' => bcrypt('password')
        ]);
        $admin->assignRole('Administrador');

        // Instructor User
        // $instructor = User::firstOrCreate([
        //     'email' => 'instructor@educapp.com'
        // ], [
        //     'name' => 'Instructor Demo',
        //     'password' => bcrypt('password')
        // ]);
        // $instructor->assignRole('Instructor');

        // Student User
        // $student = User::firstOrCreate([
        //     'email' => 'alumno@educapp.com'
        // ], [
        //     'name' => 'Alumno Demo',
        //     'password' => bcrypt('password')
        // ]);
        // $student->assignRole('Alumno');

        // Legacy Admin Support (optional, keeping original if needed)
        $legacyAdmin = User::firstOrCreate([
            'email' => 'Administrador@administrador.com'
        ], [
            'name' => 'Administrador Legacy',
            'password' => bcrypt('123456789')
        ]);
        $legacyAdmin->assignRole('Administrador');
    }
}
