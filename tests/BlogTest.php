<?php

namespace Rizalmovic\Blog\Tests;

use Blog;

class BlogTest extends TestCase
{
    public function testAdd()
    {
        $this->assertSame(Blog::add(1, 2), 3);
    }

}