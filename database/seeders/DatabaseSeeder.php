<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Medication;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::insert([
            [
                'id' => 1,
                'email' => 'sid@gmail.com',
                'name' => 'test',
                'phone' => '0123456789',
                'type' => 'admin',
                'password' => '$2y$10$3RvXBNG8Fdi9/Op238fZieqBxQHe7tybTlua.CNW.kbvpqr3ioGOq',
            ],
            [
                'id' => 2,
                'email' => 'doctor@gmail.com',
                'name' => 'try',
                'phone' => '0123456789',
                'type' => 'doctor',
                'password' => '$2y$10$LS40GbXGUXBhsNtWDAoRQOnPSTefDcy./nAZM64aB/Fra.iT/8OvG',
            ],
            [
                'id' => 3,
                'email' => 'ahmad@gmail.com',
                'name' => 'ahmad',
                'phone' => '0123456789',
                'type' => 'doctor',
                'password' => '$2y$10$traYOeBREj2i3nOX3DkY2.6RoEECM/zoQZznQHYBzI6muHNyeLjua',
            ],
            [
                'id' => 4,
                'email' => 'patient@gmail.com',
                'name' => 'patient',
                'phone' => '0123456789',
                'type' => 'patient',
                'password' => '$2y$10$traYOeBREj2i3nOX3DkY2.6RoEECM/zoQZznQHYBzI6muHNyeLjua',
            ],
            [
                'id' => 5,
                'email' => 'patient2@gmail.com',
                'name' => 'patient2',
                'phone' => '0123456789',
                'type' => 'patient',
                'password' => '$2y$10$traYOeBREj2i3nOX3DkY2.6RoEECM/zoQZznQHYBzI6muHNyeLjua',
            ],
        ]);

        Medication::insert([
            [
                'name' => 'bethamethasone 200g',
                'price' => 8,
            ],
            [
                'name' => 'panadol 10 pills',
                'price' => 5.2,
            ],
            [
                'name' => 'ubat batuk',
                'price' => 3.8,
            ],
            [
                'name' => 'ubat selsema',
                'price' => 8.5,
            ],
            [
                'name' => 'gaviscon 200g',
                'price' => 5.6,
            ],
            [
                'name' => 'aqueous cream 500g',
                'price' => 12.5,
            ],
        ]);
    }
}
