<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\PermissionsModel;
use Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $permissions = PermissionsModel::all()->pluck('name');
        foreach ($permissions as $permission) {
            Gate::define($permission, function ($user) use ($permission) {
                $user_permissions = collect($user->role->role_permissions->pluck('permission.name'));
                if (in_array($permission, $user_permissions->toArray())) {
                    return true;
                }
            });
        }
    }
}
