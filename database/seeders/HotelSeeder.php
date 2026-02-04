<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hotel;

class HotelSeeder extends Seeder
{
    public function run(): void
    {
        // HAPUS DATA TANPA TRUNCATE (AMAN UNTUK FOREIGN KEY)
        Hotel::query()->delete();

        // === HOTEL 1 ===
        Hotel::create([
            'name' => 'MaxOneHotels',
            'district' => 'Balikpapan Kota',
            'map_link' => 'https://maps.app.goo.gl/ekZrq2ub7x8NMs6J6',
            'description' => 'Hotel mewah dengan pemandangan laut yang indah, cocok untuk liburan keluarga dan bisnis.',
            'image_url' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1600&fit=crop',
            'price_per_night' => 500000,
            'is_available' => true,
        ]);

        // === HOTEL 2 ===
        Hotel::create([
            'name' => 'Central Plaza Hotel',
            'district' => 'Balikpapan Tengah',
            'description' => 'Hotel modern di pusat kota dengan akses mudah ke pusat perbelanjaan dan transportasi.',
            'about_property' => 'Hotel modern di pusat kota dengan akses mudah ke pusat perbelanjaan dan transportasi.',
            'general_facilities' => [
                'Wifi Gratis',
                'Parkir Luas',
                'Resepsionis 24 Jam',
            ],
            'image_url' => 'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=1600&fit=crop',
            'price_per_night' => 350000,
            'is_available' => true,
        ]);

        // === HOTEL 3 ===
        Hotel::create([
            'name' => 'East View Resort',
            'district' => 'Balikpapan Timur',
            'description' => 'Resort dengan kolam renang pribadi dan taman yang luas, ideal untuk relaksasi.',
            'image_url' => 'https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?w=1600&fit=crop',
            'price_per_night' => 450000,
            'is_available' => true,
        ]);

        // === HOTEL 4 ===
        Hotel::create([
            'name' => 'West Coast Inn',
            'district' => 'Balikpapan Barat',
            'description' => 'Penginapan cozy dengan suasana pedesaan, dekat dengan pantai dan area wisata.',
            'image_url' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=1600&fit=crop',
            'price_per_night' => 250000,
            'is_available' => true,
        ]);

        // === HOTEL 5 ===
        Hotel::create([
            'name' => 'South Gate Hotel',
            'district' => 'Balikpapan Selatan',
            'description' => 'Hotel bisnis dengan fasilitas meeting room dan gym, cocok untuk perjalanan dinas.',
            'image_url' => 'https://images.unsplash.com/photo-1559592413-7cec4d0cae2b?w=1600&fit=crop',
            'price_per_night' => 400000,
            'is_available' => true,
        ]);

        // === HOTEL 6 ===
        Hotel::create([
            'name' => 'North Star Boutique',
            'district' => 'Balikpapan Utara',
            'description' => 'Hotel boutique dengan desain unik dan layanan personalized untuk pengalaman menginap yang istimewa.',
            'image_url' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=1600&fit=crop',
            'price_per_night' => 600000,
            'is_available' => false,
        ]);
    }
}
