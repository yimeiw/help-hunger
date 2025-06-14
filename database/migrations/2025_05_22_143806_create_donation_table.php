<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('donation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donatur_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('event_id')->constrained('events_donatur')->onDelete('cascade');
            $table->float('amount');
            $table->enum('payment_status', ['pending', 'success', 'failed'])->default('pending');
            $table->datetime('payment_date');
            $table->string('payment_proof')->nullable();
            $table->enum('payment_method', ['BCA', 'Master Card', 'Link Aja'])->default('BCA');
            $table->string('certificate_path')->nullable();
            $table->string('receipt_url')->nullable();                 
            $table->string('transaction_reference')->nullable();      
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation');
    }
};
