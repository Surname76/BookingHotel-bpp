<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('booking_requests', function (Blueprint $table) {
        $table->dropForeign('booking_requests_room_type_id_foreign');
        $table->dropColumn('room_type_id');
    });
}

public function down()
{
    Schema::table('booking_requests', function (Blueprint $table) {
        $table->foreignId('room_type_id')->nullable()->constrained();
    });
}
};
