<?php

namespace Rizalmovic\Blog\Tests;

use Rizalmovic\Blog\BlogFacade;
use Rizalmovic\Blog\BlogServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    /**
     * Load package service provider
     * @param  \Illuminate\Foundation\Application $app
     * @return Rizalmovic\Blog\BlogServiceProvider
     */
    protected function getPackageProviders($app)
    {
        return [BlogServiceProvider::class];
    }
    /**
     * Load package alias
     * @param  \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'Blog' => BlogFacade::class,
        ];
    }
}