<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Partner;
use App\Models\PartnerAccounts;


class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Community
        $zeroWaste = Partner::create([
            'province_id' => 6,
            'city_id' => 23,
            'partner_name' => 'Zero Waste',
            'partner_email' => 'zero@gmail.com',
            'password' => bcrypt('zero'),
            'partner_link' => 'https://zerowaste.id/',
            'type' => 'community',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        PartnerAccounts::insert([
            [
                'partner_id' => $zeroWaste->id,
                'rekening_type' => 'BCA',
                'no_rekening' => '8325161741',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'partner_id' => $zeroWaste->id,
                'rekening_type' => 'Master Card',
                'no_rekening' => '1234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'partner_id' => $zeroWaste->id,
                'rekening_type' => 'Link Aja',
                'no_rekening' => '1234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        $foodCycle = Partner::create([
            'province_id' => 6,
            'city_id' => 24,
            'partner_name' => 'Food Cycle',
            'partner_email' => 'food@gmail.com',
            'password' => bcrypt('food'),
            'partner_link' => 'https://foodcycle.id/',
            'type' => 'community',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        PartnerAccounts::insert([
            [
                'partner_id' => $foodCycle->id,
                'rekening_type' => 'BCA',
                'no_rekening' => '2900387647',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'partner_id' => $foodCycle->id,
                'rekening_type' => 'Master Card',
                'no_rekening' => '1234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'partner_id' => $foodCycle->id,
                'rekening_type' => 'Link Aja',
                'no_rekening' => '1234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);


        $wastePower = Partner::create([
            'province_id' => 6,
            'city_id' => 25,
            'partner_name' => 'Waste Power',
            'partner_email' => 'waste@gmail.com',
            'password' => bcrypt('waste'),
            'partner_link' => 'https://wastepowerindonesia.com/',
            'type' => 'community',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        PartnerAccounts::insert([
            [
                'partner_id' => $wastePower->id,
                'rekening_type' => 'BCA',
                'no_rekening' => '1234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'partner_id' => $wastePower->id,
                'rekening_type' => 'Master Card',
                'no_rekening' => '1234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'partner_id' => $wastePower->id,
                'rekening_type' => 'Link Aja',
                'no_rekening' => '1234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // NGO

        $yayasanKarina = Partner::create([
            'province_id' => 6,
            'city_id' => 26,
            'partner_name' => 'Yayasan Karina',
            'partner_email' => 'karina@gmail.com',
            'password' => bcrypt('karina'),
            'partner_link' => 'https://www.karina.or.id/',
            'type' => 'ngo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        PartnerAccounts::insert([
            [
                'partner_id' => $yayasanKarina->id,
                'rekening_type' => 'BCA',
                'no_rekening' => '1234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'partner_id' => $yayasanKarina->id,
                'rekening_type' => 'Master Card',
                'no_rekening' => '1234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'partner_id' => $yayasanKarina->id,
                'rekening_type' => 'Link Aja',
                'no_rekening' => '1234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        $arthaGraha = Partner::create([
            'province_id' => 6,
            'city_id' => 27,
            'partner_name' => 'Artha Graha Peduli',
            'partner_email' => 'artha@gmail.com',
            'password' => bcrypt('artha'),
            'partner_link' => 'https://www.arthagrahapeduli.org/',
            'type' => 'ngo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        PartnerAccounts::insert([
            [
                'partner_id' => $arthaGraha->id,
                'rekening_type' => 'BCA',
                'no_rekening' => '1234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'partner_id' => $arthaGraha->id,
                'rekening_type' => 'Master Card',
                'no_rekening' => '1234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'partner_id' => $arthaGraha->id,
                'rekening_type' => 'Link Aja',
                'no_rekening' => '1234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);


        $mizanAmanah = Partner::create([
            'province_id' => 5,
            'city_id' => 19,
            'partner_name' => 'Mizan Amanah',
            'partner_email' => 'mizan@gmail.com',
            'password' => bcrypt('mizan'),
            'partner_link' => 'https://mizanamanah.org/',
            'type' => 'ngo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        PartnerAccounts::insert([
            [
                'partner_id' => $mizanAmanah->id,
                'rekening_type' => 'BCA',
                'no_rekening' => '1234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'partner_id' => $mizanAmanah->id,
                'rekening_type' => 'Master Card',
                'no_rekening' => '1234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'partner_id' => $mizanAmanah->id,
                'rekening_type' => 'Link Aja',
                'no_rekening' => '1234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);


        // Orphanage

        $anakSurga = Partner::create([
            'province_id' => 5,
            'city_id' => 20,
            'partner_name' => 'Rumah Anak Surga',
            'partner_email' => 'anaksurga@gmail.com',
            'password' => bcrypt('surga'),
            'partner_link' => 'https://yayasansayapibu.or.id/',
            'type' => 'orphanage',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        PartnerAccounts::insert([
            [
                'partner_id' => $anakSurga->id,
                'rekening_type' => 'BCA',
                'no_rekening' => '1234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'partner_id' => $anakSurga->id,
                'rekening_type' => 'Link Aja',
                'no_rekening' => '1234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'partner_id' => $anakSurga->id,
                'rekening_type' => 'Master Card',
                'no_rekening' => '1234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);


        $kasihAnugerah = Partner::create([
            'province_id' => 5,
            'city_id' => 21,
            'partner_name' => 'Rumah Pemulihan Kasih Anugerah',
            'partner_email' => 'anugerah@gmail.com',
            'password' => bcrypt('anugerah'),
            'partner_link' => ' https://pantiasuhankasihanugerah.com/',
            'type' => 'orphanage',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        PartnerAccounts::insert([
            [
                'partner_id' => $kasihAnugerah->id,
                'rekening_type' => 'BCA',
                'no_rekening' => '1234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'partner_id' => $kasihAnugerah->id,
                'rekening_type' => 'Master Card',
                'no_rekening' => '1234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'partner_id' => $kasihAnugerah->id,
                'rekening_type' => 'Link Aja',
                'no_rekening' => '1234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        $mamreGKPI = Partner::create([
            'province_id' => 5,
            'city_id' => 22,
            'partner_name' => 'Panti Asuhan Mamre GKPI',
            'partner_email' => 'mamre@gmail.com',
            'password' => bcrypt('mamre'),
            'partner_link' => 'https://www.gkpi.or.id/',
            'type' => 'orphanage',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

         PartnerAccounts::insert([
            [
                'partner_id' => $mamreGKPI->id,
                'rekening_type' => 'BCA',
                'no_rekening' => '1234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'partner_id' => $mamreGKPI->id,
                'rekening_type' => 'Master Card',
                'no_rekening' => '1234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'partner_id' => $mamreGKPI->id,
                'rekening_type' => 'Link Aja',
                'no_rekening' => '1234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        
    }
}
