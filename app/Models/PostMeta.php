<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostMeta extends Model
{
    protected $table = 'wp_postmeta'; // Mapping to the WordPress post meta table

    protected $fillable = ['post_id', 'meta_key', 'meta_value'];

    public $timestamps = false; // wp_postmeta does not use Laravel timestamps by default

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
