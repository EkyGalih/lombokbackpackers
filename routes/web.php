<?php

use App\Http\Controllers\Frontend\BookingController;
use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\InvoiceController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\PostsController;
use App\Http\Controllers\Frontend\TourController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', [HomeController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::group(['prefix' => 'bookings'], function () {
        Route::get('/', [BookingController::class, 'index'])->name('bookings.index');
        Route::post('/store', [BookingController::class, 'store'])->name('bookings.store');
        Route::get('/{booking}', [BookingController::class, 'show'])->name('bookings.show');
        Route::get('/verify/{booking}', [BookingController::class, 'verify'])->name('bookings.verify');
        Route::get('/{booking}/invoice', [BookingController::class, 'download'])->name('bookings.invoice');
    });

    Route::group(['prefix' => 'payments'], function () {
        Route::get('/{booking}', [PaymentController::class, 'create'])->name('payments.create');
        Route::post('/{booking}/payment', [PaymentController::class, 'payment'])->name('payments.payment');
        Route::get('/{payment}/verify', [PaymentController::class, 'verify'])->name('payments.verify');
        // Route::post('/{booking}', [PaymentController::class, 'store'])->name('payments.store');
        Route::get('/invoice/{booking}/download', [InvoiceController::class, 'download'])
            ->name('invoice.download');
    });



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

Route::post('booking/{id}', [BookingController::class, 'booking'])->name('booking_now');

Route::group(['prefix' => 'destinations'], function () {
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/{slug}', [CategoryController::class, 'show'])->name('categories.show');
});
Route::group(['prefix' => 'tours'], function () {
    Route::get('/', [TourController::class, 'index'])->name('tours.index');
    Route::get('/{slug}', [TourController::class, 'show'])->name('tours.show');
    Route::post('/rate/{tour}', [TourController::class, 'rate'])->name('tours.rate')->middleware('auth');
});

Route::group(['prefix' => 'blog'], function () {
    Route::get('/{slug}', [PostsController::class, 'show'])->name('blog.show');
});

require __DIR__ . '/auth.php';

Route::get('/verify-email/{id}/{hash}', function ($id, $hash) {
    $user = User::findOrFail($id);

    if (! hash_equals(sha1($user->getEmailForVerification()), $hash)) {
        abort(403, 'Invalid verification link.');
    }

    if (! $user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
    }

    return redirect()->route('dashboard')->with('status', 'Email berhasil diverifikasi!');
})->middleware(['signed'])->name('verification.verify');
