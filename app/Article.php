<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public $timestamps = null;
    protected $fillable = ['media', 'titre', 'description', 'date', 'lien', 'categorie'];

    public function politicians()
    {
        return $this->belongsToMany(Politician::class);
    }
}
