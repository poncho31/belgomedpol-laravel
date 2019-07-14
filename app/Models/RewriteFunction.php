<?php
namespace App\Models;

use App\Models\Tools;

class Rewritefunction
{
    public static function file_get_contents($url) {
        $response="";
        
        if (Tools::is_connected()) {
            
            $ch =  curl_init();
            curl_setopt($ch, CURLOPT_URL,$url);
            // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $data = curl_exec($ch);
            curl_close($ch);
            if (empty($data)) {
                $context = stream_context_create(['http' =>['user_agent' => 'politicus']]);
                $data = file_get_contents($url, false, $context);
            }
            $response=$data;
        }
        else{
            $response=null;
        }
        return $response;
    }
}
