<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Complete Your Payment</title>
</head>

<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6; margin: 0; padding: 20px;">
    <p>
        Dear {{ $booking->user->name }},
    </p>

    <p>
        Thank you for booking <strong>{{ $booking->tour->title['en'] ?? $booking->tour->title }}</strong> with us.
    </p>

    <p>
        To confirm your booking, please complete your payment :
    </p>
    <p style="text-align: left; margin: 30px 0;">
        <a href="{{ route('payments.create', $booking->id) }}"
            style="
               display: inline-block;
               padding: 12px 24px;
               background-color: #1D4ED8;
               color: #fff;
               text-decoration: none;
               border-radius: 4px;
               font-weight: bold;">
            Complete Payment
        </a>
    </p>

    <h3 style="margin-top: 30px; color: #1D4ED8;">Booking Details</h3>
    <table cellpadding="6" cellspacing="0"
        style="border-collapse: collapse; width: 100%; max-width: 600px; margin-bottom: 20px;">
        <tr>
            <td style="border: 1px solid #ddd;">Package</td>
            <td style="border: 1px solid #ddd;">
                <strong>{{ $booking->tour->title['en'] ?? $booking->tour->title }}</strong>
            </td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd;">Arrival Date</td>
            <td style="border: 1px solid #ddd;">{{ \Carbon\Carbon::parse($booking->arrival_date)->format('d M Y') }}
            </td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd;">Packet</td>
            <td style="border: 1px solid #ddd;">{{ $booking->packet }}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd;">Total Price</td>
            <td style="border: 1px solid #ddd;">Rp {{ number_format($booking->total_price) }}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd;">Status</td>
            <td style="border: 1px solid #ddd; color: #000000">Waiting Payment</td>
        </tr>
    </table>
    <p>
        If you have any questions, feel free to contact our team.
    </p>

    <p>
        Thank you for choosing
        <strong>{{ app(\App\Settings\WebsiteSettings::class)->site_name ?? config('app.name') }}</strong>.
    </p>

    <p>
        Best regards,<br>
        <strong>The {{ app(\App\Settings\WebsiteSettings::class)->site_name ?? config('app.name') }} Team</strong>
    </p>
</body>

</html>
