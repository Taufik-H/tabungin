<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;
use App\Models\Discussion;
use App\Models\Comment;
use App\Policies\DiscussionPolicy;
use App\Policies\CommentPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Discussion::class => DiscussionPolicy::class,
        Comment::class => CommentPolicy::class,
    
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('access-admin', function (User $user) {
            return $user->hasRole('admin');
        });
        
        Gate::define('create-discussion', function (User $user) {
            return $user->hasRole('user') || $user->hasRole('admin');
        });
        
        Gate::define('edit-discussion', function (User $user, Discussion $discussion) {
            return $user->id === $discussion->user_id || $user->hasRole('admin');
        });
        
        Gate::define('delete-discussion', function (User $user, Discussion $discussion) {
            return $user->id === $discussion->user_id || $user->hasRole('admin');
        });
        
        Gate::define('edit-comment', function (User $user, Comment $comment) {
            return $user->id === $comment->user_id || $user->hasRole('admin');
        });
        
        Gate::define('delete-comment', function (User $user, Comment $comment) {
            return $user->id === $comment->user_id || $user->hasRole('admin');
        });
    }
}