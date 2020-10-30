<?php

namespace App\Http\Controllers;

use App\Article;
use App\Scripts\php\RssScript;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        // $handle = fopen(storage_path("logs\\rssScript.log"), "r");
        // $checkHeader = true;
        // $csv = [];
        
        // while ($csvLine = fgetcsv($handle, 0, ",")) {
        //     if(isset( $csvLine[0])){
        //         $csv []=[
        //             'date' => isset( $csvLine[0])?$csvLine[0]:"",
        //             'log' => isset( $csvLine[1])?$csvLine[1]:""
        //         ];
        //     }
        // }
        // dd($csv);
        return view('administration');
    }

    public function search(Request $request){
        $parameter = $request->input('GlobalSearch');
        $globalSearch = Article::where('article', 'like', "%$parameter%")
                                ->orderBy('id', 'DESC')
                                ->orderby('date', 'DESC')
                                ->limit(100)
                                ->get();
        // dd(json_encode(count($globalSearch)));
        return $globalSearch;
    }
}
