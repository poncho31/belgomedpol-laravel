<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    public $timestamps = true;
    protected $fillable = ['message','error', 'created_at', 'updated_at'];
}
