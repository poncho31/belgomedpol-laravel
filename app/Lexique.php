<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lexique extends Model
{
    public $table = 'lexique';
    public $fillable = ['orthographe', 'lemme', 'grammaire', 'genre', 'nombre', 'frequenceLivre', 'nombreLettre'];
}
