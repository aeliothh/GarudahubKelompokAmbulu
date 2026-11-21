<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'nama' => 'Admin Garuda',
                'email' => 'admin@example.com',
                'password' => 'admin123',
                'role' => 'admin',
            ],
            [
                'nama' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'password' => 'klien123',
                'role' => 'klien',
            ],
            [
                'nama' => 'Siti Rahayu',
                'email' => 'siti@example.com',
                'password' => 'klien123',
                'role' => 'klien',
            ],
            [
                'nama' => 'Agus Wijaya',
                'email' => 'agus@example.com',
                'password' => 'klien123',
                'role' => 'klien',
            ],
            [
                'nama' => 'Dewi Lestari',
                'email' => 'dewi@example.com',
                'password' => 'dev123',
                'role' => 'developer',
            ],
            [
                'nama' => 'Eko Prasetyo',
                'email' => 'eko@example.com',
                'password' => 'dev123',
                'role' => 'developer',
            ],
            [
                'nama' => 'Fitri Handayani',
                'email' => 'fitri@example.com',
                'password' => 'dev123',
                'role' => 'developer',
            ],
            [
                'nama' => 'Gilang Ramadhan',
                'email' => 'gilang@example.com',
                'password' => 'dev123',
                'role' => 'developer',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }
}
