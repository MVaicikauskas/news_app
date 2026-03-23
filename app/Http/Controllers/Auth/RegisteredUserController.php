<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            User::COL_NAME => 'required|string|max:255',
            User::COL_EMAIL => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                function ($attribute, $value, $fail) {
                    if (User::whereBlind(User::COL_EMAIL, 'email_index', $value)->exists()) {
                        $fail(trans('validation.unique', ['attribute' => 'email']));
                    }
                },
            ],
            User::COL_PASSWORD => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            User::COL_NAME => $request->{User::COL_NAME},
            User::COL_EMAIL => $request->{User::COL_EMAIL},
            User::COL_PASSWORD => Hash::make($request->{User::COL_PASSWORD}),
            User::COL_IS_VERIFIED_BY_ADMIN => false,
        ]);

        $user->assignRole(UserRole::AUTHOR->value);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
