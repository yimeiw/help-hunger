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
        User::insert([
            [
                'province_id' => 6,
                'city_id' => 25,
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
                'gender' => 'female',
                'date_of_birth' => '2006-05-08',
                'phone' => '081234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Donatur

            [
                'province_id' => 6,
                'city_id' => 25,
                'name' => 'Claribel',
                'username' => 'clatan',
                'email' => 'clatan@gmail.com',
                'password' => bcrypt('clatan123'),
                'role' => 'donatur',
                'gender'=> 'female',
                'date_of_birth' => '2005-03-31',
                'phone' => '082233445566',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'province_id' => 6,
                'city_id' => 25,
                'name' => 'Nami',
                'username' => 'nami',
                'email' => 'nami@gmail.com',
                'password' => bcrypt('nami123'),
                'role' => 'donatur',
                'gender'=> 'female',
                'date_of_birth' => '2005-04-13',
                'phone' => '0812553376533',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Volunteer

            [
                'province_id' => 6,
                'city_id' => 27,
                'name' => 'Stefani',
                'username' => 'stef',
                'email' => 'stef@gmail.com',
                'password' => bcrypt('stef123'),
                'role' => 'volunteer',
                'gender'=> 'female',
                'date_of_birth' => '2005-10-06',
                'phone' => '081122443366',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'province_id' => 6,
                'city_id' => 25,
                'name' => 'Luffy',
                'username' => 'luffy',
                'email' => 'luffy@gmail.com',
                'password' => bcrypt('luffy123'),
                'role' => 'volunteer',
                'gender'=> 'male',
                'date_of_birth' => '1995-05-05',
                'phone' => '082283614150',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
