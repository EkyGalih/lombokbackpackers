<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class CustomVerifyEmail extends BaseVerifyEmail
{
    /**
     * Override default mail.
     */
    protected function buildMailMessage($url): MailMessage
    {
        return (new MailMessage)
            ->subject('Verifikasi Email Anda - Lombok Backpackers')
            ->view('emails.verify-email', [
                'url' => $url,
                'site' => config('app.name', 'Lombok Backpackers'),
            ]);
    }
}
