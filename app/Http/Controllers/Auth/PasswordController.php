<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $user = $request->user();
        
        // Check if the new password is the same as the current password
        if (Hash::check($validated['password'], $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['Your new password must be different from your current password.'],
            ])->errorBag('updatePassword');
        }

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated')->with('message', 'Your password has been changed successfully.');
    }
}