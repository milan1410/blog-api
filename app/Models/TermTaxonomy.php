<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TermTaxonomy extends Model
{
    protected $table = 'wp_term_taxonomy';
    protected $primaryKey = 'term_taxonomy_id';
    public $timestamps = false;

    protected $fillable = ['term_id', 'taxonomy', 'description', 'parent', 'count'];

    public function term()
    {
        return $this->belongsTo(Term::class, 'term_id');
    }

    public function children()
    {
        return $this->hasMany(TermTaxonomy::class, 'parent', 'term_taxonomy_id')->with('term');
    }
}
