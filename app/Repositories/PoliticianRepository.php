<?php
namespace App\Repositories;

use App\Politician;
use Illuminate\Support\Facades\DB;

class PoliticianRepository
{
    protected $politician;
    protected $nbPerPage = 10;


    function __construct(Politician $politician) {
	$this->politician = $politician;
    }


    public function getAll()
    {
        return $this->politician->getAll();
    }

    public function getPaginate(){
        return DB::table('politicians')
                    ->orderBy('description','DESC')
                    ->paginate($this->nbPerPage);
    }

    public function find($id)
    {
        return $this->politician->findPolitician($id);
    }


    public function delete($id)
    {
        return $this->politician->deletePolitician($id);
    }

    public function showPolitician($id){
        return Politician::whereHas('articles', function($q) use($id){
            $q->where('politicians.id', '=', $id);
        })->get();
    }

    public function getPolitician($date){
        if($date == "week"){
            $date = "date(a.date) >= date(NOW() - INTERVAL 7 DAY)";
        }
        elseif($date == "month"){
            $date = "date(a.date) >= date(NOW() - INTERVAL 1 month)";
        }
        elseif($date == "year"){
            $date = "YEAR(a.date) = ". date('Y');
        }
        elseif($date == "lastyear"){
            $date = "YEAR(a.date) = ". (date('Y') - 1);
        }
        $sql = DB::select("SELECT count(a.id) cnt, p.*  FROM politicians p
                            INNER JOIN article_politician ap ON ap.politician_id = p.id
                            INNER JOIN articles a ON ap.article_id = a.id
                           WHERE $date
                           GROUP BY p.id DESC
                           ORDER BY cnt DESC LIMIT 5", []);

        return $sql;
    }
}