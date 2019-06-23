<?php
namespace App\Repositories;

use App\Article;
use Illuminate\Support\Facades\DB;
use App\Politician;

class ArticleRepository
{
    protected $article;
    protected $nbPerPage = 10;


    function __construct(Article $article) {
	$this->article = $article;
    }


    public function getAll()
    {
        return $this->article->getAll();
    }

    public function getPaginate(){
        return DB::table('articles')
                  ->paginate($this->nbPerPage);
    }

    public function find($id)
    {
        return $this->article->findArticle($id);
    }


    public function delete($id)
    {
        return $this->article->deleteArticle($id);
    }

    public function getAllBindingPolitician(){
        return $this->article->politicians();
    }

    public function showArticle($id){
        return Article::whereHas('politicians', function($q) use($id){
            $q->where('articles.id', '=', $id);
        })->get();
    }

    public function latestArticles(){
        return DB::table('articles')->orderBy('articles.date', 'DESC')->limit(1)->offset(30);
    }
}