<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (! Schema::hasColumn('bookings', 'booking_request_id')) {
                $table->foreignId('booking_request_id')->nullable()->after('user_id')->constrained('booking_requests')->nullOnDelete();
            }

            if (! Schema::hasColumn('bookings', 'payment_id')) {
                $table->foreignId('payment_id')->nullable()->after('booking_request_id')->constrained('payments')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'payment_id')) {
                $table->dropConstrainedForeignId('payment_id');
            }

            if (Schema::hasColumn('bookings', 'booking_request_id')) {
                $table->dropConstrainedForeignId('booking_request_id');
            }
        });
    }
};

