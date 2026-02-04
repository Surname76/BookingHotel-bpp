<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            if (! Schema::hasColumn('hotels', 'about_property')) {
                $table->text('about_property')->nullable()->after('description');
            }

            if (! Schema::hasColumn('hotels', 'general_facilities')) {
                $table->json('general_facilities')->nullable()->after('about_property');
            }
        });
    }

    public function down(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            if (Schema::hasColumn('hotels', 'general_facilities')) {
                $table->dropColumn('general_facilities');
            }

            if (Schema::hasColumn('hotels', 'about_property')) {
                $table->dropColumn('about_property');
            }
        });
    }
};

