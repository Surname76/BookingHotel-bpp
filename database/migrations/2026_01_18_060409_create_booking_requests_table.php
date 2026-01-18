<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_requests', function (Blueprint $table) {
            $table->id();

            // Hotel (sementara masih pakai tabel rooms)
            $table->foreignId('room_id')
                ->constrained('rooms')
                ->cascadeOnDelete();

            // Kelas kamar
            $table->foreignId('room_type_id')
                ->constrained('room_types')
                ->cascadeOnDelete();

            // Data tamu
            $table->string('guest_name');
            $table->string('guest_email');
            $table->string('guest_phone')->nullable();

            // Tanggal menginap
            $table->date('check_in');
            $table->date('check_out');

            // Status booking request (OTA)
            $table->enum('status', [
                'pending',
                'sent',
                'confirmed',
                'rejected',
            ])->default('pending');

            // Catatan dari hotel / admin
            $table->text('note')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_requests');
    }
};
