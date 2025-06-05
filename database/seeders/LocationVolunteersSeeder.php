<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LocationVolunteers;

class LocationVolunteersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LocationVolunteers::insert([
            [
                'province_id' => 6,
                'city_id' => 25,
                'name' => 'BINUS University – Kampus Anggrek',
                'address' => 'Jl. Kebon Jeruk Raya No.27, Kebon Jeruk',
                'zipcode' => 11480,
                'latitude' => -6.201513174623481, 
                'longitude' => 106.78237271162517,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'province_id' => 6,
                'city_id' => 27,
                'name' => 'Pasar Induk Kramat Jati, Jakarta Timur',
                'address' => 'Jl. Raya Bogor, RT.9/RW.7, Kp. Tengah, Kec. Kramat jati, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13540',
                'zipcode' => 13540,
                'latitude' => -6.2947992692435175,  
                'longitude' => 106.86965620792411,
                'created_at' => now(),
                'updated_at' => now(),
            ],


            [
                'province_id' => 6,
                'city_id' => 26,
                'name' => 'Gorontalo',
                'address' => 'Jl. Jend. Sudirman No.1, Kota Gorontalo, Gorontalo',
                // 'city' => 'Gorontalo',
                'zipcode' => 96138,
                'latitude' => 0.5525397495577394, 
                'longitude' => 123.06393539439844,
                'created_at' => now(),
                'updated_at' => now(),
            ],


            [
                'province_id' => 6,
                'city_id' => 23,
                'name' => 'BINUS International - JWC Campus',
                'address' => 'Jl. Hang Lekir I No.6, RT.1/RW.3, Senayan, Kec. Kby. Baru, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10270',
                'zipcode' => 10270,
                'latitude' => -6.2288558422827185, 
                'longitude' => 106.79689946929713,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'province_id' => 6,
                'city_id' => 25,
                'name' => 'BINUS University – Kampus Syahdan',
                'address' => 'Jl. Kyai H. Syahdan No.9, Kemanggisan, Kec. Palmerah, Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta 11480',
                'zipcode' => 11480,
                'latitude' => -6.200110538275342,  
                'longitude' => 106.785430007923071,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'province_id' => 6,
                'city_id' => 26,
                'name' => 'Petukangan Utara, Jakarta Selatan',
                'address' => 'Petukangan Utara, Kec. Pesanggrahan, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12260',
                'zipcode' => 12260,
                'latitude' => -6.227435041908901,  
                'longitude' => 106.74709420607246,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
