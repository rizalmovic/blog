<?php

namespace Rizalmovic\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rizalmovic\Blog\Traits\RevisionableTrait;

class Category extends Model
{
    use SoftDeletes;
    use RevisionableTrait;

    protected $table = 'blog_categories';
    protected $fillable = ['title', 'parent_id'];

    public static function boot()
    {
        parent::boot();
        static::bootRevision();
        static::creating(function($model){
            $model->slug = $model->slug ? $model->slug : $model->generateSlug();
        });
    }

    public function generateSlug()
    {
        $slug = str_slug($this->title);
        $exists = static::where('slug', $slug)->count();

        if(!$exists) {
            return $slug;
        }

        $counter = 1;
        while(true)
        {
            $__slug = $slug . '-' . ($counter);
            $exists = static::where('slug', $__slug)->count();

            if(!$exists) {
                break;
            }

            $counter++;
        }

        return $__slug;
    }
}