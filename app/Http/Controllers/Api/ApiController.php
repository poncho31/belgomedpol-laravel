<?php

namespace App\Http\Controllers\Api;

use App\Scripts\php\RssScript;

class ApiController{
    public function index(){
        set_time_limit(6000);
        (new RssScript)->RssToDB();
    }
}