<?php

namespace App\Http\Controllers;

use App\Repositories\ArticleRepository;
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
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $weekPoliticians = $this->politicianRepo->getPolitician("week");
        $monthPoliticians = $this->politicianRepo->getPolitician("month");
        $yearPoliticians = $this->politicianRepo->getPolitician("year");
        $lastyearPoliticians = $this->politicianRepo->getPolitician("lastyear");
        // (new RssScript)->getPoliticianCitationsByArticle();
        return view('home', compact('weekPoliticians', 'monthPoliticians','yearPoliticians','lastyearPoliticians'));
    }

    public function language(){
		session('locale', session('locale') == 'fr' ? 'en' : 'fr');
		return redirect()->back();
    }
}