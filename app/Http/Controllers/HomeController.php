<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PoliticianRepository;
use App\Repositories\ArticleRepository;

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