<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique()->nullable(); // Kode promo opsional
            $table->text('description')->nullable();
            
            // Tipe diskon
            $table->enum('type', [
                'room_type',           // Diskon per tipe kamar (single/twin)
                'extended_stay',       // Diskon menambah waktu inap
                'weekday',            // Diskon hari tertentu
                'seasonal',           // Diskon musiman
                'early_bird'          // Diskon booking jauh hari
            ]);
            
            // Nilai diskon
            $table->enum('discount_type', ['percentage', 'fixed']); // Persen atau nominal
            $table->decimal('discount_value', 10, 2);
            
            // Minimum requirements
            $table->integer('min_nights')->nullable(); // Min malam untuk extended stay
            $table->decimal('min_amount', 10, 2)->nullable(); // Min transaksi
            
            // Applicable conditions
            $table->json('applicable_room_types')->nullable(); // ['single', 'twin']
            $table->json('applicable_days')->nullable(); // [1,2,3,4,5] untuk weekdays
            $table->json('applicable_hotel_ids')->nullable(); // Hotel tertentu
            $table->json('applicable_room_ids')->nullable(); // Room tertentu
            
            // Periode berlaku
            $table->date('valid_from');
            $table->date('valid_until');
            
            // Limits
            $table->integer('max_usage')->nullable(); // Total max penggunaan
            $table->integer('usage_count')->default(0);
            $table->integer('max_usage_per_user')->nullable();
            
            $table->boolean('is_active')->default(true);
            $table->boolean('is_stackable')->default(false); // Bisa dikombinasi dengan promo lain
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};