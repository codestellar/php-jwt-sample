<?php
require "../vendor/autoload.php";
use \Firebase\JWT\JWT;

// used to get mysql database connection
class ConfigService{

    private static $secret = "M@ddy";

    public static function getSecret(){
        return self::$secret;
    }

    public static function decodeSecret($jwt){
        return JWT::decode($jwt, self::$secret, array('HS256'));
    }

    public static function encodeSecret($token){
        return JWT::encode($token, self::$secret);
    }
}
?>