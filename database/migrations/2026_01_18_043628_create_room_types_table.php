<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('room_types', function (Blueprint $table) {
            $table->id();

            // Relasi ke hotel (rooms)
            $table->foreignId('room_id')
                  ->constrained('rooms')
                  ->cascadeOnDelete();

            $table->string('name'); // Standard / Deluxe / Suite
            $table->decimal('price_per_night', 10, 2);
            $table->boolean('is_available')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('room_types');
    }
};
