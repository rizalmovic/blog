<?php

namespace Rizalmovic\Blog;

use Illuminate\Support\ServiceProvider;

class BlogServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Blog::class, function () {
            return new Blog();
        });

        $this->app->alias(Blog::class, 'blog');
    }
}