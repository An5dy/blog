<?php

namespace App\Providers;

use App\Contracts\BlogCache;
use App\Extensions\Cache\CacheAble;
use App\Extensions\Cache\CacheUnable;
use Illuminate\Support\ServiceProvider;

class CacheServiceProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BlogCache::class, function ($app) {
            if (! is_admin()) {
                return new CacheAble();
            } else {
                return new CacheUnable();
            }
        });
    }

    /**
     * 返回由提供器注册的服务容器绑定
     *
     * @return array
     */
    public function provides(): array
    {
        return [BlogCache::class];
    }
}
