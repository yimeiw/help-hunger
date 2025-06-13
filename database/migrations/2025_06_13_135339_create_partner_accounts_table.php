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
        Schema::create('partner_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained('partner')->onDelete('cascade');
            $table->enum('rekening_type', ['BCA', 'Master Card', 'Link Aja']);
            $table->string('no_rekening');
            // Optional: Add a unique constraint if a partner can only have one account of each type
            $table->unique(['partner_id', 'rekening_type']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partner_accounts');
    }
};
