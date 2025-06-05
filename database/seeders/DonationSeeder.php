<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Donation;

class DonationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Donation::insert([
            [
                'amount' => 50000.0,
                'payment_status' => 'success',
                'payment_date' => now(),
                'payment_proof' => 'null',
                'payment_method' => 'bca',
                'receipt_url' => 'null',
                'transaction_reference' => 'null',
                'donatur_id' => 2,
                'event_id' => 1,
                'created_at' => now(), 
                'updated_at' => now(),
            ],

            [
                'amount' => 100000.0,
                'payment_status' => 'success',
                'payment_date' => now(),
                'payment_proof' => 'null',
                'payment_method' => 'bca',
                'receipt_url' => 'null',
                'transaction_reference' => 'null',
                'donatur_id' => 3,
                'event_id' => 1,
                'created_at' => now(), 
                'updated_at' => now(),
            ],

            [
                'amount' => 100000.0,
                'payment_status' => 'success',
                'payment_date' => now(),
                'payment_proof' => 'null',
                'payment_method' => 'bca',
                'receipt_url' => 'null',
                'transaction_reference' => 'null',
                'donatur_id' => 3,
                'event_id' => 2,
                'created_at' => now(), 
                'updated_at' => now(),
            ],

            [
                'amount' => 150000.0,
                'payment_status' => 'pending',
                'payment_date' => now(),
                'payment_proof' => 'null',
                'payment_method' => 'bca',
                'receipt_url' => 'null',
                'transaction_reference' => 'null',
                'donatur_id' => 3,
                'event_id' => 3,
                'created_at' => now(), 
                'updated_at' => now(),
            ],

            [
                'amount' => 200000.0,
                'payment_status' => 'success',
                'payment_date' => now(),
                'payment_proof' => 'null',
                'payment_method' => 'bca',
                'receipt_url' => 'null',
                'transaction_reference' => 'null',
                'donatur_id' => 2,
                'event_id' => 4,
                'created_at' => now(), 
                'updated_at' => now(),
            ],

            [
                'amount' => 250000.0,
                'payment_status' => 'pending',
                'payment_date' => now(),
                'payment_proof' => 'null',
                'payment_method' => 'bca',
                'receipt_url' => 'null',
                'transaction_reference' => 'null',
                'donatur_id' => 2,
                'event_id' => 5,
                'created_at' => now(), 
                'updated_at' => now(),
            ],

            [
                'amount' => 300000.0,
                'payment_status' => 'success',
                'payment_date' => now(),
                'payment_proof' => 'null',
                'payment_method' => 'bca',
                'receipt_url' => 'null',
                'transaction_reference' => 'null',
                'donatur_id' => 3,
                'event_id' => 6,
                'created_at' => now(), 
                'updated_at' => now(),
            ],


        ]);
    }
}
