<?php

namespace App\Providers;

use App\Models\About;
use App\Models\Article;
use Laravel\Passport\Passport;
use App\Observers\AboutObserver;
use App\Observers\ArticleObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Article::observe(ArticleObserver::class);// 文章观察者
        About::observe(AboutObserver::class);// 关于观察者
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Passport::ignoreMigrations();// 不用 passport 默认迁移
    }
}
