<?php

namespace Rizalmovic\Blog;

use Illuminate\Support\Facades\Facade;

class BlogFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'blog';
    }
}