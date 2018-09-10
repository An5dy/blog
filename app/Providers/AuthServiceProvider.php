<?php

namespace App\Providers;

use Carbon\Carbon;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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

        Passport::routes();// passport 路由

        // 设置 passport 路由失效时间
        $passportConfig = config('api.passport');
        Passport::tokensExpireIn(Carbon::now()->addSeconds($passportConfig['access_token_expire']));
        Passport::refreshTokensExpireIn(Carbon::now()->addSeconds($passportConfig['refresh_token_expire']));
    }
}
