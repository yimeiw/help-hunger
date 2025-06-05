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
        Schema::create('events_donatur', function (Blueprint $table) {
            $table->id();
            $table->string('event_name');
            $table->text('event_description');
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->string('image_path')->nullable();
            $table->foreignId('partner_id')->constrained('partner')->onDelete('cascade');
            $table->foreignId('location_id')->constrained('location_donatur')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events_donatur');
    }
};
