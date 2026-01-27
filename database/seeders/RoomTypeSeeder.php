<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoomType;

class RoomTypeSeeder extends Seeder
{
    public function run(): void
    {
        // Delete existing room types
        RoomType::query()->delete();

        RoomType::create([
            'room_id' => 1,
            'name' => 'Standard Room',
            'description' => 'Cocok untuk perjalanan singkat',
            'capacity' => 2,
            'price_per_night' => 350000,
            'benefits' => [
                'Tempat tidur standar',
                'AC & Wifi',
                'Kamar mandi pribadi',
                'TV layar datar',
            ],
            'is_available' => true,
        ]);

        RoomType::create([
            'room_id' => 1,
            'name' => 'Deluxe Room',
            'description' => 'Lebih luas dan nyaman',
            'capacity' => 2,
            'price_per_night' => 550000,
            'benefits' => [
                'Tempat tidur Queen Size',
                'Area duduk tambahan',
                'Kamar mandi lebih luas',
                'Complimentary kopi & teh',
                'View kota',
            ],
            'is_available' => true,
        ]);

        RoomType::create([
            'room_id' => 1,
            'name' => 'Suite Room',
            'description' => 'Fasilitas premium',
            'capacity' => 2,
            'price_per_night' => 850000,
            'benefits' => [
                'Ruang tidur terpisah',
                'Ruang tamu pribadi',
                'Kamar mandi premium',
                'Privasi lebih tinggi',
                'Layanan prioritas',
            ],
            'is_available' => false,
        ]);
    }
}
