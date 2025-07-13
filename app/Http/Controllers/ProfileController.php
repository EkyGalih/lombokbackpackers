<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
            'customer' => $request->user()->customer
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request)
    {
        $user = $request->user();

        $user->update($request->only('name', 'email'));

        $customer = $user->customer;

        if ($customer) {
            $customer->update($request->only([
                'phone',
                'address',
                'nationality',
                'gender',
                'date_of_birth'
            ]));
        } else {
            $user->customer()->create($request->only([
                'phone',
                'address',
                'nationality',
                'gender',
                'date_of_birth'
            ]));
        }

        return back()->with('status', 'Profile Saved');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
