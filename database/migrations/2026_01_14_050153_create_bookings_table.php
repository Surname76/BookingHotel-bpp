<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('room_id')
                ->constrained()
                ->cascadeOnDelete();

            // DATA TAMU
            $table->string('guest_name');
            $table->string('guest_email');
            $table->string('guest_phone')->nullable();

            // TANGGAL BOOKING
            $table->date('check_in');
            $table->date('check_out');

            // HARGA
            $table->decimal('price_per_night', 10, 2);
            $table->integer('total_nights');
            $table->decimal('total_price', 12, 2);

            // STATUS
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])
                ->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
