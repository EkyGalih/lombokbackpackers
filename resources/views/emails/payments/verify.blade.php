<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Verification</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full text-center animate-fade-in">
        <svg class="mx-auto mb-4 w-16 h-16 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 8v4m0 4h.01M12 2a10 10 0 110 20 10 10 0 010-20z" />
        </svg>

        <h2 class="text-2xl font-bold mb-2 text-gray-800">Payment Under Verification</h2>
        <p class="text-gray-600 mb-4">
            Thank you for submitting your payment proof. Our team is currently verifying your payment.
            We will notify you once the verification is complete.
        </p>

        <div class="flex justify-center space-x-2">
            <a href="{{ route('dashboard') }}"
                class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm font-medium">
                Back to Home
            </a>
            <a href="{{ route('bookings.show', $payment->booking->id) }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                View Booking Status
            </a>
        </div>
    </div>

</body>

</html>
