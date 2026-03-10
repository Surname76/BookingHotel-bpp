<?php

use App\Livewire\Admin\BookingRequestList;
use App\Models\BookingRequest;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('shows edited check-in and check-out times in admin booking request panel', function (): void {
    $admin = User::factory()->create([
        'is_admin' => true,
    ]);

    $hotel = Hotel::query()->create([
        'name' => 'MaxOneHotels',
        'district' => 'Balikpapan Kota',
        'price_per_night' => 500000,
        'is_available' => true,
    ]);

    $room = Room::query()->create([
        'hotel_id' => $hotel->id,
        'name' => 'Superior',
        'price_per_night' => 500000,
        'is_available' => true,
    ]);

    $bookingRequest = BookingRequest::query()->create([
        'user_id' => $admin->id,
        'room_id' => $room->id,
        'guest_name' => 'fathi',
        'guest_email' => 'fathi@hotel.com',
        'guest_phone' => '12312',
        'check_in' => '2026-03-12',
        'check_in_time' => '14:00',
        'check_out' => '2026-03-14',
        'check_out_time' => '15:00',
        'status' => 'pending',
    ]);

    Livewire::actingAs($admin)
        ->test(BookingRequestList::class)
        ->assertSee('12 Mar 2026 (14:00)')
        ->assertSee('14 Mar 2026 (15:00)')
        ->call('select', $bookingRequest->id)
        ->assertSee('2026-03-12 14:00')
        ->assertSee('2026-03-14 15:00');
});
