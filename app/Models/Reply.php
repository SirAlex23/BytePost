<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Reply extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'replies';

    protected $fillable = [
        'thread_id',
        'content',
        'author_id',
        'author_name',
    ];

    public function thread()
    {
        return $this->belongsTo(Thread::class, 'thread_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}