<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('room_types', function (Blueprint $table) {
            // HANYA tambahkan capacity
            if (!Schema::hasColumn('room_types', 'capacity')) {
                $table->unsignedTinyInteger('capacity')->nullable()->after('description');
            }
        });
    }

    public function down(): void
    {
        Schema::table('room_types', function (Blueprint $table) {
            if (Schema::hasColumn('room_types', 'capacity')) {
                $table->dropColumn('capacity');
            }
        });
    }
};
