<?php
namespace App\Models;

use phpseclib\Net\SFTP;
use App\Lexique;

class Tools
{
    public static function is_connected()
    {
        $connected = @fsockopen("www.google.com", 80); 
        if ($connected){
            $is_conn = true;
            fclose($connected);
        }else{
            $is_conn = false;
        }
        return $is_conn;
    
    }

    public static function sftp($host, $user, $pass, $srcPath, $mode = "r"){
        $sftp = new SFTP($host);
        if (!$sftp->login($user, $pass)) {
            return "error";
        }
        $sftp->put('../httpd.private/FTP/'. basename($srcPath), $srcPath, SFTP::SOURCE_LOCAL_FILE);
        return "success";
    }
    
    public static function regexConstructor(string $string){
        preg_match_all('/[a-zA-Zéèàôê-]+/', $string, $matches);
        // dump($matches);
        foreach ($matches[0] as $word) {
            // dump($word);
            $searchWord = Lexique::where("lemme", $word)->first();
            // dd($lemme);
            if($searchWord != null || $searchWord != ""){
                $grammar = $searchWord->grammaire;
                $genre = $searchWord->genre;
                $number = $searchWord->nombre;
                $numberLetter = $searchWord->nombreLettre;
                $wordLength = strlen($word);
                $nbStrToRem = in_array("VER",$searchWord->cgramortho)? $word:substr($word, 0, ($wordLength/4>=1?-($wordLength - Math.round($wordLength/3)):0));
                dump($word);
                dump($grammar);
                dump($number);
                dump($numberLetter);


            } 
        }
        // => problème pour les verbes ...
        return $matches;
    }
}
