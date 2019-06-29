<?php

namespace App\Http\Controllers;

use App\Politician;
use Illuminate\Http\Request;
use App\Repositories\ArticleRepository;
use App\Repositories\PoliticianRepository;
use Illuminate\Support\Facades\DB;
use App\Scripts\php\RssScript;

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
        $latestPoliticians = $this->politicianRepo->latestPoliticians();
        $latestArticles = $this->articleRepo->latestArticles();
        return view('home', compact('latestPoliticians', 'latestArticles'));
    }
}
;