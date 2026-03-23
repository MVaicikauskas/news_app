<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            User::COL_PASSWORD => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            User::COL_PASSWORD => Hash::make($validated[User::COL_PASSWORD]),
        ]);

        return back();
    }
}
