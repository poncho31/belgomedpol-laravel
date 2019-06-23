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

    public function latestPoliticians(){
        return DB::table('poltiicians')->orderBy('politicians.id', 'DESC')->limit(10)->offset(30);
    }
}