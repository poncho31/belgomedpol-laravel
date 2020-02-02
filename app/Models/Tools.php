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
}
