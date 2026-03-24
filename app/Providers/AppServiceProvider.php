<?php

namespace App\Providers;

use App\Enums\UserRole;
use App\Models\User;
use App\Models\Post;
use App\Notifications\NewAuthorRegisteredNotification;
use App\Observers\PostObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);

        Password::defaults(function () {
            $rule = Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols();

            return $this->app->isProduction()
                ? $rule->uncompromised()
                : $rule;
        });

        Post::observe(PostObserver::class);
        User::observe(UserObserver::class);

        Event::listen(
            Verified::class,
            function (Verified $event) {
                if ($event->user->hasRole(UserRole::AUTHOR->value)) {
                    $admins = User::role(UserRole::ADMIN->value)->get();
                    Notification::send($admins, new NewAuthorRegisteredNotification($event->user));
                }
            }
        );
    }
}
