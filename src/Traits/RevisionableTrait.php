<?php

namespace Rizalmovic\Blog\Traits;

use Rizalmovic\Blog\Models\Revision;
use Illuminate\Support\Str;
use Auth;

trait RevisionableTrait
{
    public $prev_state = [];

    public static function boot()
    {
        parent::bootRevision();
    }

    public static function bootRevision()
    {
        static::created(function($model) {
            $model->addRevision('create');
        });

        static::updating(function($model) {
            $model->setState();
        });

        static::updated(function($model) {
            $model->addRevision('update');
        });

        static::deleting(function($model){
            $model->setState();
        });

        static::deleted(function($model){
            $model->addRevision('delete');
        });

        static::restoring(function($model){
            $model->setState();
        });

        static::restored(function($model){
            $model->addRevision('restore');
        });
    }

    public function addRevision($type)
    {
        $revision = new Revision();

        $revision->type  = $type;
        $revision->batch = (string) Str::uuid();
        $revision->revisionable_type = get_class($this);
        $revision->revisionable_id = $this->id;
        $revision->number = $this->getRevisionNumber();
        $revision->fields = json_encode($this->getChanges());
        $revision->prev_state = $this->prev_state ? json_encode($this->prev_state) : null;
        $revision->current_state = json_encode($this->attributes);
        $revision->author_id = ($user = Auth::user()) ? $user->id : null;
        $revision->save();
    }

    public function getChanges()
    {
        return array_keys(array_diff_assoc($this->prev_state, $this->attributes));
    }

    public function getRevisionNumber()
    {
        $exists = Revision::select(['id', 'number'])
            ->where('revisionable_type', get_class($this))
            ->where('revisionable_id', $this->id)
            ->orderBy('number', 'desc')
            ->first();

        if($exists) {
            print_r($exists->number + 1);
            return $exists->number + 1;
        }

        return 1;
    }

    public function setState()
    {
        $this->prev_state = $this->original;
    }
}