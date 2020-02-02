<?php

namespace App\Http\Controllers;

use App\Scripts\php\RssScript;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdministrationController extends Controller
{
    protected $articleRepo;
    public function __construct(){
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $handle = fopen(storage_path("app/rssScript.log"), "r");
        $checkHeader = true;
        $csv = [];
        
        while ($csvLine = fgetcsv($handle, 0, ",")) {
            if(isset( $csvLine[0])){
                $csv []=[
                    'date' => isset( $csvLine[0])?$csvLine[0]:"",
                    'log' => isset( $csvLine[1])?$csvLine[1]:""
                ];
            }
        }
        // dd($csv);
        return view('administration', compact('csv'));
    }
}
