<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Payment Verification in Progress</title>
</head>

<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6; margin: 0; padding: 20px;">
    <p>
        Dear {{ $payment->booking->user->name }},
    </p>

    <p>
        We have received your payment proof for the following booking:<br>
    </p>
    <table cellpadding="6" cellspacing="0"
        style="border-collapse: collapse; width: 100%; max-width: 600px; margin-bottom: 20px;">
        <tr>
            <td style="border: 1px solid #ddd;">Package</td>
            <td style="border: 1px solid #ddd;">
                <strong>{{ $payment->booking->tour->title['en'] ?? $payment->booking->tour->title }}</strong>
            </td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd;">Arrival Date</td>
            <td style="border: 1px solid #ddd;">{{ \Carbon\Carbon::parse($payment->booking->arrival_date)->format('d M Y') }}
            </td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd;">Packet</td>
            <td style="border: 1px solid #ddd;">{{ $payment->booking->packet }}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd;">Total Price</td>
            <td style="border: 1px solid #ddd;">Rp {{ number_format($payment->booking->total_price) }}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd;">Status</td>
            <td style="border: 1px solid #ddd; color: #fdcf01">Verification Payment</td>
        </tr>
    </table>

    <p>
        Our team is currently reviewing your payment. You will receive a confirmation email as soon as the verification
        is complete.
    </p>

    <p>
        You can check the status of your booking at any time using the link below:
    </p>

    <p style="text-align: left; margin: 30px 0;">
        <a href="{{ route('bookings.show', $payment->id) }}"
            style="
               display: inline-block;
               padding: 12px 24px;
               background-color: #1D4ED8;
               color: #fff;
               text-decoration: none;
               border-radius: 4px;
               font-weight: bold;">
            View Booking Status
        </a>
    </p>

    <p>
        Thank you for your patience and for choosing
        <strong>{{ app(\App\Settings\WebsiteSettings::class)->site_name ?? config('app.name') }}</strong>.
    </p>

    <p>
        Best regards,<br>
        <strong>The {{ app(\App\Settings\WebsiteSettings::class)->site_name ?? config('app.name') }} Team</strong>
    </p>
</body>

</html>
