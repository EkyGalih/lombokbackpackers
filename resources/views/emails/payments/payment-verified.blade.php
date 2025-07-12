<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Payment Confirmed</title>
</head>

<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6;">
    <h2>Hi {{ $payment->booking->user->name }}</h2>

    <p>
        We are pleased to inform you that we have <strong>successfully verified your payment</strong> for
        <strong>{{ $payment->booking->tour->title['en'] ?? $payment->booking->tour->title }}</strong>.
    </p>

    <p>
        Your booking is now officially <strong style="color: #1bc006">CONFIRMED</strong>.
    </p>

    <p>
        You can view your booking details and get invoice at the link below:
    </p>

    <p style="text-align: left; margin: 20px 0;">
        <a href="{{ route('bookings.show', $payment->id) }}"
            style="display: inline-block; padding: 12px 24px; background-color: #1D4ED8; color: #fff; text-decoration: none; border-radius: 4px;">
            📄 View Booking Details
        </a>
    </p>

    <p>
        Thank you for choosing
        <strong>{{ app(\App\Settings\WebsiteSettings::class)->site_name ?? config('app.name') }}</strong>.<br>
        We look forward to giving you an unforgettable experience!
    </p>

    <p>
        Best regards,<br>
        <strong>{{ app(\App\Settings\WebsiteSettings::class)->site_name ?? config('app.name') }} Team</strong>
    </p>
</body>

</html>
