<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ProvincesSeeder::class,
            CitiesSeeder::class,
            UserSeeder::class,
            PartnerSeeder::class,
            LocationVolunteersSeeder::class,
            LocationDonaturSeeder::class,
            EventsVolunteersSeeder::class,
            EventsDonaturSeeder::class,
            DonationSeeder::class,
            EventsVolunteersDetailSeeder::class,
            EventsDonationDetailsSeeder::class,
            NotificationSeeder::class,
            PartnerAccountsSeeder::class,
        ]);
    }
}
