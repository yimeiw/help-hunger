<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Partner;


class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Partner::insert([
            // Community
            [
                'partner_name' => 'Zero Waste',
                'partner_link' => 'https://zerowaste.id/',
                'type' => 'community',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'partner_name' => 'Food Cycle',
                'partner_link' => 'https://foodcycle.id/',
                'type' => 'community',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'partner_name' => 'Waste Power',
                'partner_link' => 'https://wastepowerindonesia.com/',
                'type' => 'community',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // NGO

            [
                'partner_name' => 'Yayasan Karina',
                'partner_link' => 'https://www.karina.or.id/',
                'type' => 'ngo',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'partner_name' => 'Artha Graha Peduli',
                'partner_link' => 'https://www.arthagrahapeduli.org/',
                'type' => 'ngo',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'partner_name' => 'Mizan Amanah',
                'partner_link' => 'https://mizanamanah.org/',
                'type' => 'ngo',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Orphanage
            [
                'partner_name' => 'Rumah Anak Surga',
                'partner_link' => 'https://yayasansayapibu.or.id/',
                'type' => 'orphanage',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'partner_name' => 'Rumah Pemulihan Kasih Anugerah',
                'partner_link' => ' https://pantiasuhankasihanugerah.com/',
                'type' => 'orphanage',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'partner_name' => 'Panti Asuhan Mamre GKPI',
                'partner_link' => 'https://www.gkpi.or.id/',
                'type' => 'orphanage',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
