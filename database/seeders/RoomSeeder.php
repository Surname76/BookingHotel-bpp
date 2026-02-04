<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data kamar tanpa truncate (aman untuk foreign key)
        Room::query()->delete();

        $hotels = Hotel::query()->get()->keyBy('name');

        $seedRooms = function (string $hotelName, array $rooms) use ($hotels): void {
            $hotel = $hotels->get($hotelName);
            if (! $hotel) {
                return;
            }

            foreach ($rooms as $room) {
                Room::create([
                    'hotel_id' => $hotel->id,
                    'name' => $room['name'],
                    'description' => $room['description'] ?? null,
                    'capacity' => $room['capacity'] ?? 2,
                    'price_per_night' => $room['price_per_night'],
                    'benefits' => $room['benefits'] ?? [],
                    'is_available' => $room['is_available'] ?? true,
                ]);
            }
        };

        $seedRooms('Central Plaza Hotel', [
            [
                'name' => 'Standard Room',
                'description' => 'Cocok untuk perjalanan singkat',
                'capacity' => 2,
                'price_per_night' => 350000,
                'benefits' => ['AC & Wifi', 'Kamar mandi pribadi', 'TV layar datar'],
                'is_available' => true,
            ],
            [
                'name' => 'Deluxe Room',
                'description' => 'Lebih luas dan nyaman',
                'capacity' => 2,
                'price_per_night' => 550000,
                'benefits' => ['Queen size bed', 'Area duduk', 'Kopi & teh', 'City view'],
                'is_available' => true,
            ],
            [
                'name' => 'Suite Room',
                'description' => 'Fasilitas premium',
                'capacity' => 2,
                'price_per_night' => 850000,
                'benefits' => ['Ruang tidur terpisah', 'Ruang tamu', 'Kamar mandi premium'],
                'is_available' => true,
            ],
        ]);

        $seedRooms('MaxOneHotels', [
            [
                'name' => 'Superior',
                'description' => 'Nyaman untuk keluarga kecil',
                'capacity' => 3,
                'price_per_night' => 500000,
                'benefits' => ['AC & Wifi', 'Sarapan', 'Air mineral'],
                'is_available' => true,
            ],
            [
                'name' => 'Family Room',
                'description' => 'Lebih luas untuk keluarga',
                'capacity' => 4,
                'price_per_night' => 650000,
                'benefits' => ['2 tempat tidur', 'AC & Wifi', 'Kamar mandi pribadi'],
                'is_available' => true,
            ],
        ]);

        $seedRooms('South Gate Hotel', [
            [
                'name' => 'Business Room',
                'description' => 'Cocok untuk perjalanan dinas',
                'capacity' => 2,
                'price_per_night' => 400000,
                'benefits' => ['Meja kerja', 'AC & Wifi', 'Sarapan'],
                'is_available' => true,
            ],
        ]);
    }
}

