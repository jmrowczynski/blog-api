<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

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
    }
}
