<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            
            // Nilai voucher
            $table->enum('discount_type', ['percentage', 'fixed']);
            $table->decimal('discount_value', 10, 2);
            $table->decimal('max_discount_amount', 10, 2)->nullable(); // Max potongan untuk persen
            
            // Requirements
            $table->decimal('min_purchase', 10, 2)->nullable();
            $table->integer('min_nights')->nullable();
            
            // Applicable to
            $table->json('applicable_hotel_ids')->nullable();
            $table->json('applicable_room_ids')->nullable();
            
            // Periode
            $table->date('valid_from');
            $table->date('valid_until');
            
            // Limits
            $table->integer('total_quantity')->nullable(); // Total voucher tersedia
            $table->integer('used_quantity')->default(0);
            $table->integer('max_usage_per_user')->default(1);
            
            // Type
            $table->enum('voucher_type', ['public', 'private', 'referral'])->default('public');
            
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};