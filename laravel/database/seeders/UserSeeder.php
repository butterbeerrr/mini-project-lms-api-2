<?php

namespace Database\Seeders;

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
            //Instructor
            [
                'name' => 'Budi Setiawan',
                'email' => 'budi.setiawan@example.com',
                'password' => Hash::make('password123'),
                'role' => 'instructor',
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi.lestari@example.com',
                'password' => Hash::make('password123'),
                'role' => 'instructor',
            ],
            [
                'name' => 'Eko Prasetyo',
                'email' => 'eko.prasetyo@example.com',
                'password' => Hash::make('password123'),
                'role' => 'instructor',
            ],
            [
                'name' => 'Siti Aminah',
                'email' => 'siti.aminah@example.com',
                'password' => Hash::make('password123'),
                'role' => 'instructor',
            ],
            //Student
            [
                'name' => 'Rian Hidayat',
                'email' => 'rian.hidayat@example.com',
                'password' => Hash::make('password123'),
                'role' => 'student',
            ],
            [
                'name' => 'Aditya Nugroho',
                'email' => 'aditya.nugroho@example.com',
                'password' => Hash::make('password123'),
                'role' => 'student',
            ],
            [
                'name' => 'Fitriani Siregar',
                'email' => 'fitriani.siregar@example.com',
                'password' => Hash::make('password123'),
                'role' => 'student',
            ],
            [
                'name' => 'Rizky Ramadhan',
                'email' => 'rizky.ramadhan@example.com',
                'password' => Hash::make('password123'),
                'role' => 'student',
            ],
            [
                'name' => 'Dinda Permatasari',
                'email' => 'dinda.permata@example.com',
                'password' => Hash::make('password123'),
                'role' => 'student',
            ],
            [
                'name' => 'Agus Budiman',
                'email' => 'agus.budiman@example.com',
                'password' => Hash::make('password123'),
                'role' => 'student',
            ],
            [
                'name' => 'Mega Utami',
                'email' => 'mega.utami@example.com',
                'password' => Hash::make('password123'),
                'role' => 'student',
            ],
            [
                'name' => 'Hendra Wijaya',
                'email' => 'hendra.wijaya@example.com',
                'password' => Hash::make('password123'),
                'role' => 'student',
            ],
            [
                'name' => 'Putu Ayu',
                'email' => 'putu.ayu@example.com',
                'password' => Hash::make('password123'),
                'role' => 'student',
            ],
            [
                'name' => 'Fahmi Idris',
                'email' => 'fahmi.idris@example.com',
                'password' => Hash::make('password123'),
                'role' => 'student',
            ],
            [
                'name' => 'Sri Wahyuni',
                'email' => 'sri.wahyuni@example.com',
                'password' => Hash::make('password123'),
                'role' => 'student',
            ],
        ];

        // Insert users into the database
        foreach ($users as $user) {
            User::create($user);
        }
    }
}
