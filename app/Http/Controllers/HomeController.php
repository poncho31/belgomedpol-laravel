<?php

namespace App\Http\Controllers;

use App\Politician;
use Illuminate\Http\Request;
use App\Repositories\ArticleRepository;
use App\Repositories\PoliticianRepository;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    protected $politicianRepo;
    protected $articleRepo;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PoliticianRepository $politicianRepo, ArticleRepository $articleRepo)
    {
        // $this->middleware('auth');
        $this->politicianRepo = $politicianRepo;
        $this->articleRepo = $articleRepo;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $description = "Philippe Courard, à l’époque ministre wallon de l’intérieur, avait été appelé à la rescousse";
        $pol =  DB::table('politicians')
                ->whereRaw("QUOTE('".addslashes($description)."') LIKE CONCAT('%',lastname, '%')")
                ->whereRaw("QUOTE('".addslashes($description)."') LIKE CONCAT('%',firstname, '%')")
                ->get();
                dd($pol);
        $latestPoliticians = $this->politicianRepo->latestPoliticians();
        $latestArticles = $this->articleRepo->latestArticles();
        return view('home', compact('latestPoliticians', 'latestArticles'));
    }
}
;