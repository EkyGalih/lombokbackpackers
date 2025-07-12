@component('mail::message')
    # Hi {{ $payment->booking->user->name }}

    Thank you for submitting your payment proof for **{{ $payment->booking->tour->title['en'] ?? $payment->booking->tour->title }}**.

    Your payment is currently **being verified by our team**.
    We will notify you as soon as the verification is complete.

    You can check the status of your booking anytime at the link below:

    @component('mail::button', ['url' => route('bookings.show', $payment->id)])
        View Booking Status
    @endcomponent

    Thank you for your patience,<br>
    **{{ app(\App\Settings\WebsiteSettings::class)->site_name ?? config('app.name') }}**
@endcomponent
