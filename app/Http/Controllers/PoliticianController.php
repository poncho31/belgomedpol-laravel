<?php

namespace App\Http\Controllers;

use App\Politician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\PoliticianRepository;

class PoliticianController extends Controller
{
    protected $politicianRepo;
    public function __construct(PoliticianRepository $politicianRepo)
    {   
        $this->politicianRepo = $politicianRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->input('lastname')  || $request->input('firstname')){
            $politicians = Politician::whereHas('articles', function($q) use($request){
                if($request->lastname) {$q->where('politicians.lastname', 'like', "%".$request->lastname."%");}
                if($request->firstname){$q->where('politicians.firstname', 'like', "%".$request->firstname."%");}
            });
        }
        else{
            $politicians = Politician::whereHas('articles', function($q){
            });
        }
        $politicians = $politicians->withCount('articles')
                                   ->orderBy('articles_count', 'DESC')
                                   ->paginate();
        $links = $politicians->links();
        return view('politician', compact('politicians', 'links'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Politician  $politician
     * @return \Illuminate\Http\Response
     */
    public function show($politician)
    {
        $politician = $this->politicianRepo->showPolitician($politician);
        return view('politician.view', compact('politician'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Politician  $politician
     * @return \Illuminate\Http\Response
     */
    public function edit(Politician $politician)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Politician  $politician
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Politician $politician)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Politician  $politician
     * @return \Illuminate\Http\Response
     */
    public function destroy(Politician $politician)
    {
        //
    }
}
