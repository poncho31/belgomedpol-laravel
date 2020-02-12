<?php
namespace App\Scripts\php;
use App\Article;
use App\Models\API;
use App\Politician;
use Masterminds\HTML5;
use PHPHtmlParser\Dom;
use App\Scripts\php\Data;
use FeedIo\Factory as FeedIo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

// Script permettant de mettre à jour la BDD media (articles issus des flux RSS)
class RssScript{
    protected $db;
    protected $nasTest = 0;

    public function __construct()
    {
    }
    public function RssToDB($count = 0){
        $this->log('###BEGIN SCRIPT####');
        try {
            $feeds = Data::feeds();
            $totalDuration = -microtime(true);
            $newArticlesTotal = 0;
            $relationTotal = 0;
            foreach ($feeds as $url) {
                $durationFeed = -microtime(true);
                $newArticles = 0;
                $newRelations = 0;
                $this->log("###Feed : $url");//LOG
                // Va chercher les feeds
                try {
                    $feeds = FeedIo::create()->getFeedIo()->read($url)->getFeed();
                } catch (\Throwable $e) {
                    $this->log("####CURL exception on $url : {$e->getMessage()}");
                    $feeds = [];
                }
                // Parcours les articles d'un flux rss
                try {
                    foreach ($feeds as $feed) {
                        // CHECK si article déjà en BDD
                        $isInDB = Article::where('lien','=', $feed->getLink())->first();
                        if (!$isInDB) {
                            // INSERT article en BDD
                            $article = $this->getArticle($feed);
                            // CHECK et INSERT politiciens liés aux articles
                            $newRelations += $this->getRelationArticlePoliticians($article);
                            $newArticles++;
                        }
                    }
                } catch (\Throwable $e) {
                    $this->log("####XML exception on $url : {$e->getMessage()}");
                }
                $durationFeed += microtime(true);
                $this->log("###Articles : $newArticles");//LOG
                $this->log("###Relations : $newRelations");//LOG
                $this->log("###Duration : $durationFeed");//LOG
                $relationTotal+=$newRelations;
                $newArticlesTotal+=$newArticles;
            }

            $totalDuration += microtime(true);
            $this->log("##Total Articles : $newArticlesTotal");//LOG
            $this->log("##Total Relations : $relationTotal");//LOG
            $this->log("##Total Duration : $totalDuration");//LOG
            
        } catch (\Throwable $e) {
            $this->log("####$e");
            $this->log($count);
            if ($count < 5) {
                $this->RssToDB($count ++);
            }
        }
    }

    public function getArticle($feed, $update = ["update"=>false, "id"=>""]){
        $article = ($update['update'])? Article::find($update['id']) : new Article;

        if (!$update['update']) {
            $mediaName = explode('.',isset(parse_url( $feed->getLink())['host'])?parse_url($feed->getLink())['host']:$feed->getLink())[1];
            $article->media = ($mediaName == "google")?"rtl":$mediaName;
            $article->titre = $feed->getTitle();
            $article->description = strip_tags($feed->getDescription());
            $article->date = $feed->getLastModified()->format('Y-m-d H:i:s');
            $article->lien = $feed->getLink();
            $article->article = ($article->media=="rtl")?null:$this->getCompleteArticle($article->lien, $article->media); // pour rtl la description contient tout l'article
        }else{
            $article->article = ($article->media=="rtl")?null:$this->getCompleteArticle($article->lien, $article->media);
            $article->number_testing++;
        }
        $article->save();
        return $article;
    }
    public function getCompleteArticle($url, $media){
        $dom = new Dom;
        $dom->setOptions([
            'removeDoubleSpace'=>true
        ]);
        $dom->loadFromUrl($url);
        $data = "";
        foreach (Data::mediasTag()[$media] as $tag) {
            if($data == ""){
                $content = $dom->find($tag);
                foreach($content as $e){
                    foreach ($e->find('a') as $a){
                        $a->delete();
                    }
                    $data .= $e->innerHtml;
                }
            }
        }
        return html_entity_decode(trim(strip_tags(htmlspecialchars_decode($data, ENT_QUOTES))));
    }
    
    public function getRelationArticlePoliticians($article){
        // article content => description or article complete
        $articleContent = (empty($article->article) || $article->article == ""?$article->description:$article->article);
        $relations = DB::table('politicians')
                ->whereRaw("QUOTE('".addslashes($articleContent)."') LIKE CONCAT('%',lastname,' ', firstname, '%')")
                ->orWhereRaw("QUOTE('".addslashes($articleContent)."') LIKE CONCAT('%',firstname,' ', lastname, '%')")
                ->orWhereRaw("QUOTE('".addslashes($article->titre)."') LIKE CONCAT('%',firstname,' ', lastname, '%')")
                ->orWhereRaw("QUOTE('".addslashes($article->titre)."') LIKE CONCAT('%',lastname,' ', firstname, '%')")
                ->get();
        $newRelations = 0;
        foreach($relations as $pol){
            // Attach politician to article
            $article->politicians()->attach($pol->id);
            // API wikipedia
            $this->getPoliticianInformations("$pol->firstname $pol->lastname", $pol->id);
            $this->log("###Relation : $pol->firstname $pol->lastname");
            $newRelations++;
            $this->nasTest();
        }
        return $newRelations;
    }

    public function getPoliticianInformations($politician, $id){
        $description="";$descriptionLink="";$imageLink="";$status="";
        // Check if already test more than 5 times
        if(Politician::where('id',$id)->where('number_testing','<', 5)->first()){
            try {
                // get information
                $content = API::wikipedia($politician, "content");
                $description = (isset($content[2][0]) && $content[2][0] != '')? $content[2][0] : null;
                $descriptionLink = (isset($content[3][0]) && $content[3][0] != '' ) ? $content[3][0] : null;
                
                // Get image url
                $image = API::wikipedia($politician, "image");
                $imageLink = (!empty($image['query']['pages'][0]))? ((!empty($image['query']['pages'][0]['thumbnail']['source']))? $image['query']['pages'][0]['thumbnail']['source']: null) : null;
                $status =  (!empty($image['query']['pages'][0])) ? (!empty($image['query']['pages'][0]['terms']['description'][0])?($image['query']['pages'][0]['terms']['description'][0]) : null) : null;     
            } catch (\Throwable $th) {
                $this->log("####ERROR API - WIKIPEDIA :{$th->getMessage()}");
            }
            // INSERT
            try {
                $politician= Politician::find($id);
                $politician->description = $description;
                $politician->lienDescription = $descriptionLink;
                $politician->image = $imageLink;
                $politician->statut = $status;
                $politician->number_testing++;
                $politician->save();
            } catch (\Throwable $th) {
                $this->log("####ERROR SQL INSERT POLITICIAN INFORMATIONS :{$th->getMessage()}");
            }
        }

    }

    public function getPoliticianCitationsByArticle($firstname = "elio", $lastname = "di rupo"){
        $regex = '/("([^"]|"")*")/';
        // $regex = '/(["\'])(\\?.)*?\1/';
        // $regex = '/"(.*?)".+['.$lastname.'].+\./';
        // $regex = "/[A-Za-z,;'\"\\s]+[.?!]/";
        // $regex = '/[^\.\!\?]*^["|\']\.\!\?]/';
        // $regex = '/(["])(?:(?=(\\?))\2.)*?\1/';
        // $regex = '/\..*['.$lastname.'].*("([^"]|"")*").*['.$lastname.']?.*\./';
        $regex = '/["|\s\'](.*?)["|\'\s]/';
        $content = Article::whereHas('politicians', function($q) use ($lastname, $firstname){
            $q->where('politicians.lastname', $lastname)->where('politicians.firstname',$firstname);
        })->get();
        // dd($content);
        $matches="";
        foreach($content as $a){
            dump($a->article);
            preg_match_all($regex, $a->article, $matches);
            dump($matches);
            die();
        }
        die();


    }

    public function repairCompleteAll(){
        // ARTICLES GET COMPLETE
        
        $incompleteArticles = Article::where('article', "=", "")->where('number_testing', '<', '5')->get();
        $this->log("##INCOMPLETE ARTICLES : ".count($incompleteArticles));
        foreach ($incompleteArticles as $incArticle) {
            $this->log("##TRYING UPDATE ARTICLE NUMBER $incArticle->id");
            $article = $this->getArticle("", ['update'=>true, "id"=>$incArticle->id]);
            // POLITICIAN GET ARTICLE RELATION
            $this->getRelationArticlePoliticians($article);
        }
        // REMOVE DUPLICATE ROWS
        DB::select("DELETE t1 FROM article_politician t1
                        INNER JOIN article_politician t2 
                    WHERE 
                        t1.id < t2.id AND
                        t1.politician_id = t2.politician_id AND
                        t1.article_id = t2.article_id
                ");
    }

    public function nasTest(){
        if (env('APP_DEBUG')) {
            $this->nasTest++;
            if($this->nasTest > 5){
                $this->log("####TEST");
                exit();
            }
        }
    }
    public function log($content){
        if (env('APP_DEBUG')) {
            echo $content . "\n";
        }
        else{
            try {
                Storage::disk('local')->append("rssScript.log", date("d-m-Y H:i:s").",$content\n");
            } catch (\Throwable $e) {
                $this->log("###ERROR log insert : {$e->getMessage()}");
            }
        }
    }

}