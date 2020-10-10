<?php

namespace Source\Security;

class Encrypt{

    private static $encrypt_method = "AES-256-CBC";

    private static $key_iv = ENCRYPT_KEY;

    

    private function getKey($key = ""){
        if($key == "")
            return hash('sha256', ENCRYPT_HASH);
        else
        return hash('sha256', $key);
    }

    public static function encryptData($string){
        return base64_encode(openssl_encrypt($string,self::$encrypt_method,self::getKey(),0,self::$key_iv));
    }
    

    public static function decryptData($hash){
        return openssl_decrypt(base64_decode($hash), self::$encrypt_method, self::getKey(), 0, self::$key_iv);
    }

    public static function validateHash($encrypted, $data){
        return self::encryptData($data) == $encrypted;
    }

    public static function encryptDataByKey($data, $key){
        return base64_encode(openssl_encrypt($data,self::$encrypt_method,self::getKey($key),0,self::$key_iv));
    }
    public static function decryptDataByKey($hash, $key){
        return openssl_decrypt(base64_decode($hash), self::$encrypt_method, self::getKey($key), 0, self::$key_iv);
    }

}

?>