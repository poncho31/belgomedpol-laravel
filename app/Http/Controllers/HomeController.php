<?php

namespace App\Http\Controllers;

use App\Politician;
use Illuminate\Http\Request;
use App\Scripts\php\RssScript;
use Illuminate\Support\Facades\DB;
use App\Repositories\ArticleRepository;
use Illuminate\Support\Facades\Session;
use App\Repositories\PoliticianRepository;

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

    public function language(){
		session('locale', session('locale') == 'fr' ? 'en' : 'fr');
		return redirect()->back();
    }
}