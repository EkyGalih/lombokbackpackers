<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class BookingStatusChanged extends Notification
{
    use Queueable;

    public function __construct(public Booking $booking) {}

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Status Booking Anda Diperbarui')
            ->greeting('Hai ' . $notifiable->name . ',')
            ->line('Booking Anda untuk ' . $this->booking->tour->title . ' sekarang berstatus:')
            ->line('**' . strtoupper($this->booking->status) . '**')
            ->action('Lihat Booking', url('/dashboard/bookings'))
            ->line('Terima kasih telah menggunakan layanan Travelnesia!');
    }

    public function toArray($notifiable)
    {
        return [
            'booking_id' => $this->booking->id,
            'status' => $this->booking->status,
            'tour_title' => $this->booking->tour->title,
        ];
    }
}
