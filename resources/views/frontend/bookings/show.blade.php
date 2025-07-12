<x-app-layout>
    <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg px-10 py-8 mt-12">
        <h1 class="text-4xl font-extrabold text-blue-700 text-center mb-1">Invoice</h1>
        <p class="text-center text-gray-500">Invoice #: <span
                class="font-semibold">{{ $booking->invoice_number ?? 'INV-' . $booking->id }}</span></p>
        <p class="text-center text-gray-500 mb-8">Issued: <span
                class="font-medium">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</span></p>

        <div class="border rounded-lg p-6 mb-8">
            <h2 class="text-lg font-semibold text-blue-600 mb-3">Customer</h2>
            <p class="text-gray-800 leading-6">
                <span class="font-medium">{{ $booking->user->name }}</span><br>
                <span>{{ $booking->user->email }}</span><br>
                <span>{{ $booking->user->phone ?? '-' }}</span>
            </p>
        </div>

        <div class="border rounded-lg p-6 mb-8">
            <h2 class="text-lg font-semibold text-blue-600 mb-3">Booking Details</h2>
            <table class="w-full text-sm text-gray-700">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-4 py-2 text-left">Package</th>
                        <th class="px-4 py-2 text-left">Departure</th>
                        <th class="px-4 py-2 text-left">Participants</th>
                        <th class="px-4 py-2 text-right">Price</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $booking->tour->title['en'] ?? $booking->tour->title }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($booking->departure_date)->format('d M Y') }}
                        </td>
                        <td class="px-4 py-2">{{ $booking->participants ?? 1 }}</td>
                        <td class="px-4 py-2 text-right">Rp {{ number_format($booking->total_price) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="border rounded-lg p-6 mb-8">
            <h2 class="text-lg font-semibold text-blue-600 mb-3">Payment Summary</h2>
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($booking->total_price) }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Tax</span>
                    <span>Rp 0</span>
                </div>
                <div class="flex justify-between font-bold border-t pt-2 mt-2">
                    <span>Total</span>
                    <span>Rp {{ number_format($booking->total_price) }}</span>
                </div>
            </div>
        </div>
        <div class="text-center mb-6">
            @if ($booking->status == \App\Enums\BookingStatus::Pending)
                <p class="text-gray-700">
                    Please complete payment before
                    <span class="font-medium">
                        {{ \Carbon\Carbon::parse($booking->payment_due_date)->format('d M Y') }}
                    </span>
                    to confirm your booking.
                </p>
                <a href="{{ route('payments.create', $booking->id) }}"
                    class="inline-block mt-4 bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold py-3 px-6 rounded-full shadow-md">
                    Complete Payment
                </a>
            @elseif ($booking->status == \App\Enums\BookingStatus::Waiting)
                <p class="text-orange-700">
                    Your payment is currently <span class="font-medium">being verified by our team</span>.
                    You will be notified once the verification is complete.
                </p>
            @elseif ($booking->status == \App\Enums\BookingStatus::Approved)
                <p class="text-gray-700">
                    Your booking has been <span class="font-medium text-green-600">approved</span>.
                    You can download your invoice below.
                </p>
                <a href="{{ route('bookings.invoice', $booking->id) }}"
                    class="inline-block mt-4 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold py-3 px-6 rounded-full shadow-md">
                    Download Invoice
                </a>
            @endif
        </div>

        <p class="text-center text-gray-500 text-sm">
            Need help? Contact us at <a href="mailto:{{ app(\App\Settings\WebsiteSettings::class)->contact_email }}"
                class="text-blue-600 underline">{{ app(\App\Settings\WebsiteSettings::class)->contact_email }}</a>.
        </p>
        <p class="text-center text-xs text-gray-400 mt-1">
            &copy; {{ date('Y') }}
            {{ app(\App\Settings\WebsiteSettings::class)->site_name ?? config('app.name') }}. All rights reserved.
        </p>
    </div>
</x-app-layout>
