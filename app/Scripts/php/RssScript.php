<?php
namespace App\Scripts\php;
use App\Article;
use App\Politician;
use App\Scripts\php\Data;
use FeedIo\Factory as FeedIo;
use Illuminate\Support\Facades\DB;

// Script permettant de mettre à jour la BDD media (articles issus des flux RSS)
class RssScript{
    protected $db;

    public function __construct()
    {
    }

    public function log($content, $echo = true){
        if ($echo) {
            echo $content . "\n";
        }
        else{
            $log = "";
            $file = "./rssScript.log";
            if(!file_exists($file)){
                $log .= "date,data\n";
            }
            $log .= date("d-m-Y H:i:s").",$content\n";
            file_put_contents($file, $log, FILE_APPEND);
        }
    }

    public function RssToDB(){
        $this->log('####BEGIN SCRIPT####');
        try {
            $feeds = Data::feeds();
            $totalDuration = -microtime(true);
            $newArticlesTotal = 0;
            $relationTotal = 0;
            foreach ($feeds as $url) {
                $durationFeed = -microtime(true);
                $newArticles = 0;
                $newRelations = 0;
                $this->log("####Feed : $url");//LOG
                // Va chercher les feeds
                $feeds = FeedIo::create()->getFeedIo()->read($url)->getFeed();
                // Parcours les articles d'un flux rss
                foreach ($feeds as $feed) {
                    // CHECK si article déjà en BDD
                    $isInDB = Article::where('lien','=', $feed->getLink())->first();
                    if (!$isInDB) {
                        // INSERT article en BDD
                        $article = new Article;
                        $article->media = isset(parse_url($feed->getLink())['host'])?parse_url($feed->getLink())['host']:$feed->getLink();
                        $article->titre = $feed->getTitle();
                        $article->description = strip_tags($feed->getDescription());
                        $article->date = $feed->getLastModified()->format('Y-m-d H:i:s');
                        $article->lien = $feed->getLink();
                        $article->article = $this->getCompleteArticle($article->lien);
                        $article->save();
                        // CHECK et INSERT politiciens liés aux articles
                        $relation = $this->getRelationArticlePoliticians($article->description, $article->titre);
                        foreach($relation as $pol){
                            $this->log("###Relation : $pol->firstname $pol->lastname");
                            $article->politicians()->attach($pol->id);
                            $newRelations++;
                        }
                        $newArticles++;
                    }
                }
                $durationFeed += microtime(true);
                $this->log("####Articles : $newArticles");//LOG
                $this->log("####Relations : $newRelations");//LOG
                $this->log("####Duration : $durationFeed");//LOG
                $relationTotal+=$newRelations;
                $newArticlesTotal+=$newArticles;
            }

            $totalDuration += microtime(true);
            $this->log("##Total Articles : $newArticlesTotal");//LOG
            $this->log("##Total Relations : $relationTotal");//LOG
            $this->log("##Total Duration : $totalDuration");//LOG
            
        } catch (\Throwable $e) {
            $this->log($e);
        }
    }

    public function getCompleteArticle($url){
        return null;
    }

    public function getRelationArticlePoliticians($description, $titre){
        return  DB::table('politicians')
                ->whereRaw("QUOTE('".addslashes($description)."') LIKE CONCAT('%',lastname, '%')")
                ->whereRaw("QUOTE('".addslashes($description)."') LIKE CONCAT('%',firstname, '%')")
                ->orWhereRaw("QUOTE('".addslashes($titre)."') LIKE CONCAT('%',lastname, '%')")
                ->whereRaw("QUOTE('".addslashes($titre)."') LIKE CONCAT('%',firstname, '%')")
                ->get();
    }

}