<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cities;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cities::insert([
            [
                'province_id' => 1,
                'cities_name' => 'Padang',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'province_id' => 1,
                'cities_name' => 'Bukittinggi',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'province_id' => 1,
                'cities_name' => 'Padang Panjang',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'province_id' => 1,
                'cities_name' => 'Pariaman',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            [
                'province_id' => 1,
                'cities_name' => 'Payakumbuh',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'province_id' => 1,
                'cities_name' => 'Sawahlunto',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'province_id' => 1,
                'cities_name' => 'Solok',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'province_id' => 2,
                'cities_name' => 'Kupang',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'province_id' => 3,
                'cities_name' => 'Asmat',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'province_id' => 4,
                'cities_name' => 'Bandung',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'province_id' => 4,
                'cities_name' => 'Bekasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'province_id' => 4,
                'cities_name' => 'Bogor',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'province_id' => 4,
                'cities_name' => 'Cimahi',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'province_id' => 4,
                'cities_name' => 'Cirebon',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'province_id' => 4,
                'cities_name' => 'Depok',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'province_id' => 4,
                'cities_name' => 'Sukabumi',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'province_id' => 4,
                'cities_name' => 'Tasikmalaya',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'province_id' => 4,
                'cities_name' => 'Banjar',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'province_id' => 5,
                'cities_name' => 'Tangerang',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'province_id' => 5,
                'cities_name' => 'Serang',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'province_id' => 5,
                'cities_name' => 'Cilegon',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'province_id' => 5,
                'cities_name' => 'Tangerang Selatan',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                // 23
                'province_id' => 6,
                'cities_name' => 'Jakarta Pusat',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'province_id' => 6,
                'cities_name' => 'Jakarta Utara',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'province_id' => 6,
                'cities_name' => 'Jakarta Barat',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'province_id' => 6,
                'cities_name' => 'Jakarta Selatan',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'province_id' => 6,
                'cities_name' => 'Jakarta Timur',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
