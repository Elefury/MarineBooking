<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class CustomVerifyEmail extends VerifyEmail
{
    use Queueable;

    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Подтверждение email для ' . config('app.name'))
            ->markdown('emails.verify-email', [
                'verificationUrl' => $verificationUrl,
                'logoUrl' => asset('images/logo.jpg')
            ]);
    }
}


