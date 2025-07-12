<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Invoice</title>
<style>
    body {
        font-family: Arial, sans-serif;
        color: #333;
        font-size: 12px;
        margin: 20px;
    }
    .container {
        max-width: 700px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #eee;
        border-radius: 6px;
    }
    h1 {
        color: #1D4ED8;
        font-size: 24px;
        margin-bottom: 5px;
    }
    .text-center {
        text-align: center;
    }
    .text-right {
        text-align: right;
    }
    .text-left {
        text-align: left;
    }
    .mb-1 { margin-bottom: 5px; }
    .mb-3 { margin-bottom: 15px; }
    .mb-6 { margin-bottom: 30px; }
    .font-bold { font-weight: bold; }
    .font-medium { font-weight: 500; }
    .border {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 10px;
        margin-bottom: 15px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 6px 8px;
    }
    th {
        background-color: #f9fafb;
        color: #555;
        font-weight: 600;
    }
</style>
</head>
<body>

<div class="container">
    <h1 class="text-center">Invoice</h1>
    <p class="text-center mb-1">
        Invoice #: <span class="font-medium">{{ $booking->code_booking ?? 'INV-' . $booking->payment->code_payment }}</span>
    </p>
    <p class="text-center mb-6">
        Issued: <span class="font-medium">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</span>
    </p>

    <div class="border">
        <h3 class="mb-1">Customer Information</h3>
        <p class="mb-0">
            <span class="font-medium">{{ $booking->user->name }}</span><br>
            {{ $booking->user->email }}<br>
            {{ $booking->user->phone ?? '-' }}
        </p>
    </div>

    <div class="border">
        <h3 class="mb-1">Booking Details</h3>
        <table>
            <thead>
                <tr>
                    <th>Package</th>
                    <th>Departure</th>
                    <th>Participants</th>
                    <th class="text-right">Price</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $booking->tour->title['en'] ?? $booking->tour->title }}</td>
                    <td>{{ \Carbon\Carbon::parse($booking->departure_date)->format('d M Y') }}</td>
                    <td>{{ $booking->participants ?? 1 }}</td>
                    <td class="text-right">Rp {{ number_format($booking->total_price) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="border">
        <h3 class="mb-1">Payment Summary</h3>
        <table>
            <tbody>
                <tr>
                    <td>Subtotal</td>
                    <td class="text-right">Rp {{ number_format($booking->total_price) }}</td>
                </tr>
                <tr>
                    <td>Tax</td>
                    <td class="text-right">Rp 0</td>
                </tr>
                <tr>
                    <td class="font-bold">Total</td>
                    <td class="text-right font-bold">Rp {{ number_format($booking->total_price) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <p class="text-center mb-3">
        Thank you for choosing
        <span class="font-medium">{{ app(\App\Settings\WebsiteSettings::class)->site_name ?? config('app.name') }}</span>.
    </p>

    <p class="text-center" style="font-size: 10px; color: #999;">
        &copy; {{ date('Y') }}
        {{ app(\App\Settings\WebsiteSettings::class)->site_name ?? config('app.name') }}. All rights reserved.
    </p>
</div>

</body>
</html>
