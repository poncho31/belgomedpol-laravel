<?php

namespace App\Models;
use App\Lexique;
use Illuminate\Support\Facades\DB;

class Lexicon{
    public static function getRadicalVerb($verb= null){
        // sert à créer le radical d'un verbe avec prise en compte des exceptions (ex: verbe aller - allais, va, ...)
        $lexique = ($verb==null)? Lexique::where('grammaire','VER')->where('lemme', 'like', '%é%')->take(10000)->get(): Lexique::where('lemme', $verb)->get();
        
        $data = [];
        $singleVerb = "";
        foreach ($lexique as $l) {
            $lemme = utf8_decode($l->lemme);
            $ortho = utf8_decode($l->orthographe);
            $data['ortho'][$lemme][]= "$ortho";
        }
        foreach($data['ortho'] as $key=>$verb) {
            $strMatch = "";
            $strCharNotMatch = "";
            for ($i=0; count($verb) > $i; $i++){
                if($i > 0){
                    // mots à confronter => le premier mot confronté au second, puis le radical confronté au mot plus long
                    $str1 = ($strMatch=="")?$data['ortho'][$key][$i - 1] : $strMatch;
                    $str2 = $data['ortho'][$key][$i];
                    $strBig = (strlen($str1)>=strlen($str2))?$str1:$str2;
                    $strSmall = (strlen($str1)<strlen($str2))?$str1:$str2;
                    //contrôle les lettres en communs du mot courant et du mot précédent pour un lemme donné
                    $strCharMatch = "";
                    for ($y=0; strlen($strBig) > $y; $y++) { 
                        if(isset($strSmall[$y]) && $strSmall[$y] == $strBig[$y]){
                            $strCharMatch .= $strSmall[$y];
                        }else{
                            // lettres pas en commun qui serviront pour la regex (ex: trouveras aura pour regex (trouv[aientsrzo]), çad le radical 'trouv' suivi des lettres possible pour le verbe trouver)
                            $strCharNotMatch .= (strpos($strCharNotMatch, $strBig[$y]) === false)?$strBig[$y]:"";
                        }
                    }
                    $strMatch = ($strCharMatch);
                    $strNotMatch = ($strCharNotMatch);
                    // $data['radical'][$key] = "{$strCharMatch}[{$strNotMatch}]";
                }
            }
            return "{$strCharMatch}[{$strNotMatch}]";
            // $singleVerb = ($verb!=null)?"{$strCharMatch}[{$strNotMatch}]":"";
            // $lexique = DB::insert("UPDATE lexique SET verb_regex = '{$strMatch}[{$strNotMatch}]', verb_radical = '$strMatch' WHERE id = $id");
            // $lexique->verb_regex = "{$strCharMatch}[{$strNotMatch}]";
            // $lexique->verb_radical = $strCharMatch;
            // $lexique->save();
            // dd($lexique);
        }
        // dd($data['radical']);
        // if($verb==null){
        //     return $data['radical'];
        // }
        // else{
        //     return $singleVerb;
        // }
    }
    
}