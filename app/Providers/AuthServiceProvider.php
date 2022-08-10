<?php

namespace App\Providers;

use App\Models\Comment;
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
        Gate::define('seller-manage-resources', function(User $user)
        {
            return $user->role->name === 'seller' || $user->role->name === 'passant';
        });
    }
}
