<?php

namespace Rizalmovic\Blog;

use Illuminate\Support\ServiceProvider;

class BlogServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/Http/routes.php');
        $this->loadMigrationsFrom(__DIR__.'/../migrations');
    }

    public function register()
    {
        $this->app->singleton(Blog::class, function () {
            return new Blog();
        });

        $this->app->alias(Blog::class, 'blog');
    }
}