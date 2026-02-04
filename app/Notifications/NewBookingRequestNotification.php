<?php

namespace App\Notifications;

use App\Models\BookingRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewBookingRequestNotification extends Notification
{
    use Queueable;

    public function __construct(public BookingRequest $bookingRequest)
    {
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        $bookingRequest = $this->bookingRequest->loadMissing(['room.hotel']);

        return [
            'booking_request_id' => $bookingRequest->id,
            'guest_name' => $bookingRequest->guest_name,
            'guest_email' => $bookingRequest->guest_email,
            'hotel_name' => $bookingRequest->room?->hotel?->name,
            'room_name' => $bookingRequest->room?->name,
            'status' => $bookingRequest->status,
            'created_at' => optional($bookingRequest->created_at)->toISOString(),
        ];
    }
}

