<?php

namespace App\Http\Middleware;

use App\Models\Post;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
            'flash' => [
                'message' => fn () => $request->session()->get('message'),
            ],
            'can' => [
                'create_post' => $request->user() ? ($request->user()->can('create', Post::class) && (!$request->user()->hasRole(UserRole::AUTHOR->value) || $request->user()->{User::COL_IS_VERIFIED_BY_ADMIN})) : false,
            ],
            'roles' => $request->user() ? $request->user()->getRoleNames() : [],
        ];
    }
}
