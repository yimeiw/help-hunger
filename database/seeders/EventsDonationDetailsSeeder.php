<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EventsDonationDetails;

class EventsDonationDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EventsDonationDetails::insert([
            [
                'event_id' => 1,
                'donation_id' => 1,
                'donation_target' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ], 

            [
                'event_id' => 1,
                'donation_id' => 2,
                'donation_target' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ], 

            [
                'event_id' => 2,
                'donation_id' => 3,
                'donation_target' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ], 

            [
                'event_id' => 3,
                'donation_id' => 4,
                'donation_target' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ], 

            [
                'event_id' => 4,
                'donation_id' => 5,
                'donation_target' => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ], 


            [
                'event_id' => 5,
                'donation_id' => 6,
                'donation_target' => 25,
                'created_at' => now(),
                'updated_at' => now(),
            ], 

            [
                'event_id' => 6,
                'donation_id' => 7,
                'donation_target' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ], 
        ]);
    }
}
