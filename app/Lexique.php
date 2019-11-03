<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lexique extends Model
{
    public $table = 'lexique';
    public $timestamps = false;
    public $fillable = ['orthographe', 'lemme', 'grammaire', 'genre', 'nombre', 'frequenceLivre', 'nbLettre', 'verb_regex', 'ver_radical'];
}
