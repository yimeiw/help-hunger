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
                'created_at' => now(),
                'updated_at' => now(),
            ], 

            [
                'event_id' => 1,
                'donation_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ], 

            [
                'event_id' => 2,
                'donation_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ], 

            [
                'event_id' => 3,
                'donation_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ], 

            [
                'event_id' => 4,
                'donation_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ], 


            [
                'event_id' => 5,
                'donation_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ], 

            [
                'event_id' => 6,
                'donation_id' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ], 
        ]);
    }
}
