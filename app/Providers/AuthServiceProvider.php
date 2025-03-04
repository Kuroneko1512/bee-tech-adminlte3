<?php

namespace App\Providers;

use App\Policies\RolePolicy;
use Laravel\Passport\Passport;
use App\Policies\PermissionPolicy;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;
use Barryvdh\Debugbar\Facades\Debugbar;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Role::class => RolePolicy::class,
        Permission::class => PermissionPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Cấu hình thời gian hết hạn token:
        // Access token và Personal access token hết hạn sau 1 ngày:
        Passport::tokensExpireIn(now()->addDay());
        Passport::personalAccessTokensExpireIn(now()->addDay());

        // Refresh token hết hạn sau 30 ngày:
        Passport::refreshTokensExpireIn(now()->addDays(30));
    }
}
