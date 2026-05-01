<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Thread extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'threads';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'category',
        'author_id',
        'author_name',
        'status',      // open | closed
        'pinned',
        'views',
        'replies_count',
    ];

    protected $casts = [
        'pinned'        => 'boolean',
        'views'         => 'integer',
        'replies_count' => 'integer',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function replies()
    {
        return $this->hasMany(Reply::class, 'thread_id');
    }
}