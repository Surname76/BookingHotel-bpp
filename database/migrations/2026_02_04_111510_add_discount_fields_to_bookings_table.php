<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('discount_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('voucher_id')->nullable()->constrained()->onDelete('set null');
            
            $table->decimal('subtotal', 10, 2)->default(0); // Sebelum diskon
            $table->decimal('discount_amount', 10, 2)->default(0);
            // total_amount sudah ada (setelah diskon)
            
            $table->json('applied_discounts')->nullable(); // Log semua diskon yang dipakai
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['discount_id']);
            $table->dropForeign(['voucher_id']);
            $table->dropColumn(['discount_id', 'voucher_id', 'subtotal', 'discount_amount', 'applied_discounts']);
        });
    }
};