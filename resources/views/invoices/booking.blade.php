<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice Booking - {{ $booking->id }}</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        .header { text-align: center; margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; }
        .table th { background: #f4f4f4; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Invoice Booking</h2>
        <p><strong>Travelnesia</strong></p>
    </div>

    <p><strong>Nama:</strong> {{ $booking->user->name }}</p>
    <p><strong>Email:</strong> {{ $booking->user->email }}</p>
    <p><strong>Tanggal Booking:</strong> {{ $booking->booking_date->format('d M Y') }}</p>

    <h4>Detail Tour</h4>
    <table class="table">
        <tr>
            <th>Judul</th>
            <th>Harga</th>
        </tr>
        <tr>
            <td>{{ $booking->tour->title }}</td>
            <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
        </tr>
    </table>

    <h4 style="margin-top:20px">Pembayaran</h4>
    @if ($booking->payment)
    <table class="table">
        <tr>
            <th>Metode</th>
            <th>Jumlah</th>
            <th>Waktu</th>
        </tr>
        <tr>
            <td>{{ ucfirst($booking->payment->method) }}</td>
            <td>Rp {{ number_format($booking->payment->amount, 0, ',', '.') }}</td>
            <td>{{ $booking->payment->paid_at->format('d M Y H:i') }}</td>
        </tr>
    </table>
    @else
        <p><em>Belum ada pembayaran.</em></p>
    @endif

    <p style="margin-top: 30px; text-align: right;">Generated: {{ now()->format('d M Y H:i') }}</p>
</body>
</html>
