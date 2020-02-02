<?php
namespace App\Models;

use App\Lexique;

class Regex{

    public static function constructor(string $string){
        preg_match_all('/[a-zA-Zéèàôêùü-]+/', $string, $matches);
        $sentence = "";
        foreach ($matches[0] as $word) {
            $searchWord = Lexique::where("orthographe", $word)->first();
            if(isset($searchWord)){
                $grammaire = $searchWord->grammaire;
                // Contrôle si verbe
                if($grammaire == "VER"){
                    $verb = Lexicon::getRadicalVerb($searchWord->lemme);
                    $sentence .= $verb;
                }
                // Contrôle si adjectifs ou nom
                elseif($grammaire == "ADJ" || $grammaire == "NOM"){
                    $searchLemmes = Lexique::where("lemme", $word)->pluck("orthographe")->toArray();
                    if(!empty($searchLemmes)){
                        dump($searchLemmes);
                        foreach($searchLemmes as $lemme){
                            dd($lemme);
                        }
                    }

                    if($searchWord->orthographe != $searchWord->lemme){
                        // controler si pluriel et si ortho <> de lemme
                        // si c'est le cas alors comparer les deux chaines ortho et lemme
                        // afin de créer une regex du type familial <> familiaux == famili[alux]
                        $str1 = $searchWord->orthographe;
                        $str2 = $searchWord->lemme;
                        $strBig = (strlen($str1)>=strlen($str2))?$str1:$str2;
                        $strSmall = (strlen($str1)<strlen($str2))?$str1:$str2;
                        //contrôle les lettres en communs du mot courant et du mot précédent pour un lemme donné
                        $strCharMatch = "";
                        $strCharNotMatch = "";
                        for ($y=0; strlen($strBig) > $y; $y++) { 
                            if(isset($strSmall[$y]) && $strSmall[$y] == $strBig[$y]){
                                $strCharMatch .= $strSmall[$y];
                            }else{
                                // lettres pas en commun qui serviront pour la regex (ex: trouveras aura pour regex (trouv[aientsrzo]), çad le radical 'trouv' suivi des lettres possible pour le verbe trouver)
                                $strCharNotMatch .= (strpos($strCharNotMatch, $strBig[$y]) === false)?$strBig[$y]:"";
                            }
                        }
                        if($strCharNotMatch == "s"){
                            $wordCheckPlural = ($searchWord->nombre=="s")? ((substr($word,-1)== "s" ||substr($word,-1)== "x")?$word:"{$word}s?"): (($searchWord->nombre=="p")?((substr($word,-1)== "s"))? "$word?" :$word :$word);
                            $sentence .= $wordCheckPlural;
                        }else{
                            $match = "{$strCharMatch}[{$strCharNotMatch}]";
                            $sentence .= $match;
                        }
                    }
                    else{
                        $wordCheckPlural = ($searchWord->nombre=="s")? ((substr($word,-1)== "s" ||substr($word,-1)== "x")?$word:"{$word}s?"): (($searchWord->nombre=="p")?((substr($word,-1)== "s"))? "$word?" :$word :$word);
                        $sentence .= $wordCheckPlural;
                    }
                }
                // elseif(stripos($grammaire, "ART")!==false || $word == "d"){
                //     $sentence .= "[/w/s/']{10}";
                // }

                if(isset($matches[0][1]) && $matches[0][0] == $word){
                    $sentence .= "[/w/s/']{9}";
                }

                

            }else{
                $sentence .= substr($word,-1)== "s" ? "$word?" : "{$word}s?";
            }
            // dd($lemme);
            if($searchWord != null || $searchWord != ""){
                $grammar = $searchWord->grammaire;
                $genre = $searchWord->genre;
                $number = $searchWord->nombre;
                $lemme = $searchWord->lemme;
                $numberLetter = $searchWord->nbettres;
                // $wordLength = strlen($word);
                // dd(in_array("VER",explode(',','VER')));
                // $word= "apprendre";
                // dd( substr($word, 0, ($wordLength/4>=1) ? -($wordLength - round($wordLength/3)):0));
                // $nbStrToRem = in_array("VER",explode(',',$searchWord->cgramortho))? :;
                // $searchAllOrthographe = Lexique::where("radical", $searchWord->lemme)->first();
                // dump($word);
                // dump($grammar);
                // dump($number);
                // dump($searchWord->cgramortho);
                // dump($numberLetter);
                // dd($nbStrToRem);


            } 
        }
        dump($sentence);
        // => problème pour les verbes ...
        return $matches;
    }
}