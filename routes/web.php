<?php

use App\Http\Controllers\Frontend\BookingController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\InvoiceController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\TourController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/my-bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::post('/my-bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/my-bookings/{id}', [BookingController::class, 'show'])->name('bookings.show');

    Route::get('/payment/{booking}', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payment/{booking}', [PaymentController::class, 'store'])->name('payments.store');

    Route::get('/invoice/{booking}/download', [InvoiceController::class, 'download'])
        ->name('invoice.download');

    Route::post('/bookings/{booking}/upload-proof', [BookingController::class, 'uploadProof'])->name('bookings.uploadProof');

    Route::get('/locale/{locale}', function (string $locale) {
        session()->put('locale', $locale);

        // Force reload untuk Livewire
        return redirect(url()->previous() . '?_=' . $locale);
    });

    Route::get('/debug-locale/{locale}', function () {
        return [
            'session_locale' => session('locale'),
            'app_locale' => app()->getLocale(),
        ];
    });
});
// Route::middleware('auth')->get('/midtrans/token/{booking}', [SnapController::class, 'token']);
// Route::post('/payment/notify', [MidtransWebhookController::class, 'handle']);
Route::get('/tours', [TourController::class, 'index'])->name('tours.index');
Route::get('/tours/{slug}', [TourController::class, 'show'])->name('tours.show');
Route::post('/tours/rate/{tour}', [TourController::class, 'rate'])->name('tours.rate')->middleware('auth');

require __DIR__ . '/auth.php';
