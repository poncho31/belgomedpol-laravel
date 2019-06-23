<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Politician extends Model
{
    protected $fillable = ['firstname', 'lastname', 'description', 'lienDescription', 'image'];

    public function articles()
    {
        return $this->belongsToMany('App\Article')->orderBy('date', 'DESC');
    }
}
