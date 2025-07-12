@component('mail::message')
    # Hi {{ $booking->user->name }}

    Thank you for booking **{{ $booking->tour->title['en'] ?? $booking->tour->title }}**.

    Please complete your payment of **Rp {{ number_format($booking->total_price) }}** to confirm your booking.

    @component('mail::button', ['url' => route('payments.create', $booking->id)])
        Verify Payment
    @endcomponent

    Thank you,<br>
    {{ config('app.name') }}
@endcomponent
