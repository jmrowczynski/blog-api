<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Post;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        Gate::define('delete-user', function (User $user, User $userToDelete) {
            if ($user->isAdmin() || $userToDelete->id === $user->id) {
                return true;
            }
            return false;
        });

        Gate::define('get-users', function (User $user) {
            if ($user->isAdmin()) {
                return true;
            }
            return false;
        });

        Gate::define('delete-post', function (User $user, Post $post) {
            if ($user->isAdmin() || $user->isPostOwner($post)) {
                return true;
            }
            return false;
        });

        Gate::define('update-post', function (User $user, Post $post) {
            if ($user->isAdmin() || $user->isPostOwner($post)) {
                return true;
            }
            return false;
        });
    }
}
