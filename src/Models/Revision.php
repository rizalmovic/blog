<?php

namespace Rizalmovic\Blog\Models;

use Illuminate\Database\Eloquent\Model;

class Revision extends Model
{
    protected $table = 'blog_revisions';
    protected $guarded = ['id', 'created_at' , 'updated_at', 'deleted_at'];
}