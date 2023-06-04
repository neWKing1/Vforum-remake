<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
        'App\Model' => 'App\Policies\ModelPolicy',
        'App\Models\Post' => 'App\Policies\PostPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
        $this->registerPolicies();

        // Gate::define('update-post', function ($user, $post) {
        //     return $user->id == $post->author;
        // });
        // Gate::define('delete-post', function ($user, $post) {
        //     return $user->id == $post->author;
        // });
        // Gate::define('posts.update', 'App\Policies\PostPolicy@update');
        // Gate::define('posts.delete', 'App\Policies\PostPolicy@delete');
        Gate::resource('posts', 'App\Policies\PostPolicy');
        Gate::resource('comments', 'App\Policies\CommentPolicy');
        Gate::resource('tags', 'App\Policies\TagPolicy');
        Gate::before(function ($user, $ability) {
            if ($user->user_type == 1 && in_array($ability, ['delete'])) {
                return true;
            }
        });
        // Gate::after(function ($user, $ability, $result) {
        //     if ($user->user_type == 1) {
        //         return true;
        //     }
        // });
    }
}
