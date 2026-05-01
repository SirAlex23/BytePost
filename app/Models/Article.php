<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Article extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'articles';

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'cover_image',
        'category',
        'tags',
        'author_id',
        'status',        // draft | published | archived
        'source',
        'source_url',
        'ai_summary',
        'meta_description',
        'reading_time',
        'views',
        'featured',
        'language',
        'published_at',
    ];

    protected $casts = [
        'tags'         => 'array',
        'featured'     => 'boolean',
        'views'        => 'integer',
        'reading_at'   => 'datetime',
        'published_at' => 'datetime',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // Scope para artículos publicados
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    // Scope por categoría
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}