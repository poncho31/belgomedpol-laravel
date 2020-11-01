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
        $parameters = explode(';',$request->input('GlobalSearch'));
        $where="";
        $bool = true;
        foreach($parameters as $parameter){
            $link = "";
            if($bool){
                $link = "AND";
            }
            else{
                $link = "AND";
                $bool = false;
            }
            $where .= " $link article like '%$parameter%'";
        }
        $globalSearch = DB::select(DB::raw(
            "SELECT * FROM articles WHERE 1=1 $where ORDER BY id DESC, date DESC LIMIT 100"));
        // $globalSearch->orWhere('article', 'like', "%test%");
        // foreach($parameters as $parameter){
        // }
        // $globalSearch->orderBy('id', 'DESC')
        //              ->orderby('date', 'DESC')
        //              ->limit(100);
        // $globalSearch->get();
        // dd(json_encode(count($globalSearch)));
        // dump((array) $globalSearch);
        return response((array) $globalSearch);
    }
}
