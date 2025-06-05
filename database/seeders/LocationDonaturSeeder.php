<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LocationDonatur;

class LocationDonaturSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LocationDonatur::insert([
            [
                'province_id' => 1,
                'city_id' => 1,
                'name' => 'Sumatera Barat',
                'address' => 'Jl. Simpang Bukik, Nagari Batabuah, Kabupaten Agam, Sumatera Barat',
                'zipcode' => 11480,
                'latitude' => -0.3239630684098015, 
                'longitude' => 100.4169606809058,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'province_id' => 2,
                'city_id' => 8,
                'name' => 'Nusa Tenggara Timur',
                'address' => 'Nusa Tenggara Timur, Indonesia',
                'zipcode' => 11480,
                'latitude' =>-10.176170604665783, 
                'longitude' => 1123.6070365226428,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'province_id' => 3,
                'city_id' => 9,
                'name' => 'Asmat, Papua Selatan',
                'address' => 'Yipawer, Asmat, Papua Selatan, Indonesia',
                'zipcode' => 99780,
                'latitude' =>-5.001119647604944, 
                'longitude' => 138.50786027254628,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'province_id' => 4,
                'city_id' => 10,
                'name' => 'Cianjur, Jawa Barat',
                'address' => 'Jl. Raya Cianjur, Cianjur, Jawa Barat',
                'zipcode' => 43215,
                'latitude' =>-6.819595153909405, 
                'longitude' => 107.14235909595416,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'province_id' => 5,
                'city_id' => 19,
                'name' => 'Binus University – Kampus Alam Sutera',
                'address' => 'Jl. Jalur Sutera Bar. No.Kav. 21, RT.001/RW.004, Panunggangan, Kec. Pinang, Kota Tangerang, Banten 15143',
                'zipcode' => 15143,
                'latitude' =>-6.201502508571476, 
                'longitude' => 106.78222250792321, 
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'province_id' => 3,
                'city_id' => 9,
                'name' => 'Yahukimo Papua Pegunungan',
                'address' => 'Jl. Raya Yahukimo, Yahukimo, Papua Pegunungan',
                'zipcode' => 99705,
                'latitude' =>-4.4463225417483585,  
                'longitude' => 139.5868952265997,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
