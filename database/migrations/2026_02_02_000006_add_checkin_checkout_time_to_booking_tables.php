<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('booking_requests', function (Blueprint $table) {
            if (! Schema::hasColumn('booking_requests', 'check_in_time')) {
                $table->time('check_in_time')->nullable()->after('check_in');
            }
            if (! Schema::hasColumn('booking_requests', 'check_out_time')) {
                $table->time('check_out_time')->nullable()->after('check_out');
            }
        });

        Schema::table('bookings', function (Blueprint $table) {
            if (! Schema::hasColumn('bookings', 'check_in_time')) {
                $table->time('check_in_time')->nullable()->after('check_in');
            }
            if (! Schema::hasColumn('bookings', 'check_out_time')) {
                $table->time('check_out_time')->nullable()->after('check_out');
            }
        });
    }

    public function down(): void
    {
        Schema::table('booking_requests', function (Blueprint $table) {
            if (Schema::hasColumn('booking_requests', 'check_in_time')) {
                $table->dropColumn('check_in_time');
            }
            if (Schema::hasColumn('booking_requests', 'check_out_time')) {
                $table->dropColumn('check_out_time');
            }
        });

        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'check_in_time')) {
                $table->dropColumn('check_in_time');
            }
            if (Schema::hasColumn('bookings', 'check_out_time')) {
                $table->dropColumn('check_out_time');
            }
        });
    }
};

