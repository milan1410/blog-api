<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    protected $table = 'wp_terms';
    protected $primaryKey = 'term_id';
    public $timestamps = false;

    protected $fillable = ['name', 'slug', 'term_group'];

    public function taxonomy()
    {
        return $this->hasOne(TermTaxonomy::class, 'term_id', 'term_id');
    }
}
