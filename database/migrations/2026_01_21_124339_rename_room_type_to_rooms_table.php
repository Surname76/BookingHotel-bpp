<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::rename('room_types', 'rooms');
    }

    public function down(): void
    {
        Schema::rename('rooms', 'room_types');
    }
};