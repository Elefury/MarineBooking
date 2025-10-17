<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingConfirmed extends Notification implements ShouldQueue
{
    use Queueable;

    public $booking;

    public function __construct(Booking $booking)
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
            ->subject("Booking #{$this->booking->id} Confirmed")
            ->markdown('emails.booking-confirmed', [
                'booking' => $this->booking
            ]);
    }
    public function toSms($notifiable)
    {
        return "Your booking {$this->booking->code} is confirmed";
    }
}
