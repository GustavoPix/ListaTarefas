<?php

namespace Source\Auxiliares;

class Auxiliares{


    public static function randomString($qty){
        $string = "";
        for($i = 0; $i < $qty; $i++)
        {
            $string .= self::getChar();
        }
        return $string;
    }
    private function getChar()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        return $characters[rand(0, $charactersLength - 1)];
    }
    


}

?>