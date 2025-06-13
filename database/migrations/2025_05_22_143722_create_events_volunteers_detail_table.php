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
        // many to many dengan volunteer event
        Schema::create('events_volunteers_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events_volunteers')->onDelete('cascade');
            $table->foreignId('volunteer_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['accepted', 'rejected', 'pending'])->default('pending');
            $table->string('certificate_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events_volunteers_detail');
    }
};
