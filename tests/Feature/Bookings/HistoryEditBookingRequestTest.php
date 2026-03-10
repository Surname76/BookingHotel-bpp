<?php

use App\Livewire\Bookings\History;
use App\Models\BookingRequest;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('allows user to edit their non-final booking request', function (): void {
    $user = User::factory()->create();

    $hotel = Hotel::query()->create([
        'name' => 'Central Plaza Hotel',
        'district' => 'Balikpapan Tengah',
        'price_per_night' => 700000,
        'is_available' => true,
    ]);

    $room = Room::query()->create([
        'hotel_id' => $hotel->id,
        'name' => 'Standard Room',
        'price_per_night' => 700000,
        'is_available' => true,
    ]);

    $bookingRequest = BookingRequest::query()->create([
        'user_id' => $user->id,
        'room_id' => $room->id,
        'guest_name' => 'Nama Lama',
        'guest_email' => $user->email,
        'guest_phone' => '0812000000',
        'check_in' => '2026-02-10',
        'check_in_time' => '14:00',
        'check_out' => '2026-02-12',
        'check_out_time' => '12:00',
        'special_request' => 'Request lama',
        'status' => 'sent',
    ]);

    Livewire::actingAs($user)
        ->test(History::class)
        ->call('startEdit', $bookingRequest->id)
        ->set('editGuestName', 'Nama Baru')
        ->set('editGuestPhone', '0812111111')
        ->set('editCheckIn', '2026-02-11')
        ->set('editCheckOut', '2026-02-14')
        ->set('editCheckInTime', '15:00')
        ->set('editCheckOutTime', '11:00')
        ->set('editSpecialRequest', 'Request diubah')
        ->call('saveEdit')
        ->assertHasNoErrors();

    $bookingRequest->refresh();

    expect($bookingRequest->guest_name)->toBe('Nama Baru')
        ->and($bookingRequest->guest_phone)->toBe('0812111111')
        ->and($bookingRequest->check_in->toDateString())->toBe('2026-02-11')
        ->and($bookingRequest->check_out->toDateString())->toBe('2026-02-14')
        ->and($bookingRequest->check_in_time)->toBe('15:00')
        ->and($bookingRequest->check_out_time)->toBe('11:00')
        ->and($bookingRequest->special_request)->toBe('Request diubah');
});
