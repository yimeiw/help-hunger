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
                'donatur_id' => 2,
                'event_id' => 1,
                'amount' => 50000.0,
                'payment_status' => 'success',
                'payment_date' => now(),
                'payment_proof' => 'NULL',
                'payment_method' => 'BCA',
                'certificate_path' => 'NULL',
                'receipt_url' => 'NULL',
                'transaction_reference' => 'NULL',
                'created_at' => now(), 
                'updated_at' => now(),
            ],

            [
                'donatur_id' => 3,
                'event_id' => 1,
                'amount' => 100000.0,
                'payment_status' => 'success',
                'payment_date' => now(),
                'payment_proof' => 'NULL',
                'payment_method' => 'BCA',
                'certificate_path' => 'NULL',
                'receipt_url' => 'NULL',
                'transaction_reference' => 'NULL',
                'created_at' => now(), 
                'updated_at' => now(),
            ],

            [
                'donatur_id' => 3,
                'event_id' => 2,
                'amount' => 100000.0,
                'payment_status' => 'success',
                'payment_date' => now(),
                'payment_proof' => 'NULL',
                'payment_method' => 'BCA',
                'certificate_path' => 'NULL',
                'receipt_url' => 'NULL',
                'transaction_reference' => 'NULL',
                'created_at' => now(), 
                'updated_at' => now(),
            ],

            [
                'donatur_id' => 3,
                'event_id' => 3,
                'amount' => 150000.0,
                'payment_status' => 'pending',
                'payment_date' => now(),
                'payment_proof' => 'NULL',
                'payment_method' => 'BCA',
                'certificate_path' => 'NULL',
                'receipt_url' => 'NULL',
                'transaction_reference' => 'NULL',
                'created_at' => now(), 
                'updated_at' => now(),
            ],

            [
                'donatur_id' => 2,
                'event_id' => 4,
                'amount' => 200000.0,
                'payment_status' => 'success',
                'payment_date' => now(),
                'payment_proof' => 'NULL',
                'payment_method' => 'Link Aja',
                'certificate_path' => 'NULL',
                'receipt_url' => 'NULL',
                'transaction_reference' => 'NULL',
                'created_at' => now(), 
                'updated_at' => now(),
            ],

            [
                'donatur_id' => 2,
                'event_id' => 5,
                'amount' => 250000.0,
                'payment_status' => 'pending',
                'payment_date' => now(),
                'payment_proof' => 'NULL',
                'payment_method' => 'Master Card',
                'certificate_path' => 'NULL',
                'receipt_url' => 'NULL',
                'transaction_reference' => 'NULL',
                'created_at' => now(), 
                'updated_at' => now(),
            ],

            [
                'donatur_id' => 3,
                'event_id' => 6,
                'amount' => 300000.0,
                'payment_status' => 'failed',
                'payment_date' => now(),
                'payment_proof' => 'NULL',
                'payment_method' => 'BCA',
                'certificate_path' => 'NULL',
                'receipt_url' => 'NULL',
                'transaction_reference' => 'NULL',
                'created_at' => now(), 
                'updated_at' => now(),
            ],


        ]);
    }
}
