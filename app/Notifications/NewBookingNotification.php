<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\BookingRequest;

class NewBookingNotification extends Notification
{
    use Queueable;

    public $booking;

    public function __construct(BookingRequest $booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Booking Request')
            ->line('A new booking request has been submitted.')
            ->line('Guest: ' . $this->booking->guest_name)
            ->line('Email: ' . $this->booking->guest_email)
            ->line('Check-in: ' . $this->booking->check_in)
            ->line('Check-out: ' . $this->booking->check_out)
            ->action('View Booking', url('/admin/bookings/' . $this->booking->id))
            ->line('Thank you!');
    }
}