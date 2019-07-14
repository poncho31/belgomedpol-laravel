<?php

namespace App\Models;

use App\Models\Rewritefunction;

class API
{
    public static function wikipedia(string $search, string $type = "content"){
        $url = "";
        if($type == "content"){
            $url = 'https://fr.wikipedia.org/w/api.php?action=opensearch&format=json&search=%s';
        }
        elseif($type == "image"){
            $url = 'https://fr.wikipedia.org/w/api.php?action=query&format=json&prop=pageimages&generator=prefixsearch&redirects=1&formatversion=2&piprop=thumbnail&pithumbsize=250&pilimit=20&gpssearch=%s';
        }
        $resultJSON = Rewritefunction::file_get_contents(sprintf($url, urlencode($search)));
        return json_decode($resultJSON,true);
    }
}
