<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'wp_posts';
    protected $fillable = ['post_title', 'post_content', 'post_status', 'post_type'];

    public function categories()
    {
        return $this->belongsToMany(Term::class, 'wp_term_relationships', 'object_id', 'term_taxonomy_id')
                    ->whereHas('taxonomy', fn($q) => $q->where('taxonomy', 'category'));
    }

    public function tags()
    {
        return $this->belongsToMany(Term::class, 'wp_term_relationships', 'object_id', 'term_taxonomy_id')
                    ->whereHas('taxonomy', fn($q) => $q->where('taxonomy', 'post_tag'));
    }

    public function meta()
    {
        return $this->hasMany(PostMeta::class, 'post_id');
    }
}
