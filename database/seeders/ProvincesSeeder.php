<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Provinces;

class ProvincesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Provinces::insert([
            [
                'province_name' => 'Sumatera Barat',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'province_name' => 'Nusa Tenggara Timur',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'province_name' => 'Papua Selatan',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'province_name' => 'Jawa Barat',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'province_name' => 'Banten',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'province_name' => 'Jakarta',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
