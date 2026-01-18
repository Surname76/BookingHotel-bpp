<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class HotelSeeder extends Seeder
{
    public function run(): void
    {
        // HAPUS DATA TANPA TRUNCATE (AMAN UNTUK FOREIGN KEY)
        Room::query()->delete();

        // === HOTEL 1 ===
        Room::create([
            'name' => 'Standard Hotel 1',
            'district' => 'Balikpapan Utara',
            'description' => 'Hotel standar dengan fasilitas lengkap dan lokasi strategis.',
            'image_url' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1600&fit=crop',
            'price_per_night' => 0,
            'is_available' => true,
        ]);

        // === HOTEL 2 ===
        Room::create([
            'name' => 'Standard Hotel 2',
            'district' => 'Balikpapan Tengah',
            'description' => 'Hotel nyaman di pusat kota, cocok untuk bisnis dan liburan.',
            'image_url' => 'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=1600&fit=crop',
            'price_per_night' => 0,
            'is_available' => true,
        ]);
    }
}
