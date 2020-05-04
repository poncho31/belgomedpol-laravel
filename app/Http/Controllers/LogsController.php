<?php

namespace App\Http\Controllers;

use App\Logs;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    public function index(){

        return view('logs', [
            'logs'=>Logs::where('error', 0)->orderBy('id', 'desc')->get(),
            'errorLogs'=>Logs::where('error', 1)->orderBy('id', 'desc')->get()
            ]);
    }
    
}
