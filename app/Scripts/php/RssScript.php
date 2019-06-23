<?php
namespace App\Scripts\php;
use App\Article;
use App\Scripts\php\Data;
use FeedIo\Factory as FeedIo;

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
            foreach ($feeds as $url) {
                $durationFeed = -microtime(true);
                $cntNewArticle = 0;

                $this->log("####Feed : ".$url);//LOG

                $feedIo = FeedIo::create()->getFeedIo();
                $feed = $feedIo->read($url);
                // var_dump($feed);
                // die();

                // Parcours les articles d'un flux rss
                foreach ($feed->getFeed() as $feed) {
                    // Controle si article déjà en BDD
                    $isInDB = Article::where('lien','=', $feed->getLink())->first();
                    if (!$isInDB) {
                        // Insère article en BDD
                        $article = new Article;
                        // var_dump($isInDB);
                        // die();
                        $article->media = parse_url($feed->getLink())['host'];
                        $article->titre = $feed->getTitle();
                        $article->description = strip_tags($feed->getDescription());
                        $article->date = $feed->getLastModified()->format('Y-m-d H:i:s');
                        $article->lien = $feed->getLink();
                        $article->save();
                        $cntNewArticle++;
                        // $cntTotalNewArticle++;
                    }
                }
                $durationFeed += microtime(true);

                $this->log("####Articles : " . $cntNewArticle);//LOG
                $this->log("####Duration : ". $durationFeed);//LOG
            }
        } catch (\Throwable $e) {
            $this->log($e);
        }
    }

}