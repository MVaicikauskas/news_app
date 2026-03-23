<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAuthorIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if ($user && $user->hasRole(UserRole::AUTHOR->value) && !$user->{User::COL_IS_VERIFIED_BY_ADMIN}) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Jūsų paskyra laukia administratoriaus patvirtinimo.'], 403);
            }

            return redirect()->route('dashboard')->with('message', 'Jūsų paskyra laukia administratoriaus patvirtinimo.');
        }

        return $next($request);
    }
}
