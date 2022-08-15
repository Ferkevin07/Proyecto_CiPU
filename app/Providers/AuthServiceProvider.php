<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Debt;
use App\Models\Order;
use App\Models\User;
use App\Policies\CommentPolicy;
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
        //Comment::class => CommentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //Puertas ADMIN
        Gate::define('admin-manage-resources', function(User $user)
        {
            return $user->role->name === 'admin' ;
        });
        
        //Puertas CLIENT
        Gate::define('client-manage-resources', function(User $client)
        {
            return $client->role->name === 'client' ;
        });
        
        //Puertas SELLER & PASSANT
        Gate::define('assistant-manage-resources', function(User $user)
        {
            return $user->role->name === 'seller' || $user->role->name === 'passant';
        });

        //Puertas ADMIN - SELLER & PASSANT
        Gate::define('manager-manage-resources', function(User $user)
        {
            return $user->role->name === 'admin' || $user->role->name === 'seller' || $user->role->name === 'passant';
        });

        //Puertas de AUTORIAS 

        Gate::define('isClient', function(User $user, User $client){
            return $client->role->name==='passant';
        });

        Gate::define('isAuthor', function(User $user, Debt $debt){
            return $debt->user_id === $user->id;
        });

        Gate::define('isAuthorC', function (User $user, Comment $comment)
        {
            return $comment->user_id === $user->id;
        });

        Gate::define('isAuthorOrder', function (User $user, Order $order)
        {
            return $order->user_id === $user->id;
        });
    }
}
