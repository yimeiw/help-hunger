<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EventsVolunteersDetail;

class EventsVolunteersDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EventsVolunteersDetail::insert([
            [
                'event_id' => 1,
                'volunteer_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'event_id' => 2,
                'volunteer_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'event_id' => 3,
                'volunteer_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'event_id' => 4,
                'volunteer_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'event_id' => 5,
                'volunteer_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'event_id' => 6,
                'volunteer_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
