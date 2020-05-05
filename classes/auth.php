<?php

namespace auth;

use \Firebase\JWT\JWT;

class Auth{

    //Hace un encode del JWT junto con la informacion
    //no sensible del usuario. Retorna un JWT
    public static function encode($entity){
        $key = "pro3-parcial";
        $payload = array(
            "iss" => "https://github.com/braianb92/Programacion3-Parciales.git",
            "aud" => "https://github.com/braianb92/Programacion3-Parciales.git",
            "iat" => 1356999524,
            "nbf" => 1357000000,
            "id" => $entity->id,
            "email" => $entity->email
        );

        return JWT::encode($payload, $key);
    }

    //Decodifica.
    public static function decode($jwt){
        $key = "pro3-parcial";

        try {

            $obj =  JWT::decode($jwt, $key, array('HS256'));
            if(isset($obj)){
                return $obj;
            }

            return false;

        } catch (\Throwable $th) {
            return false;
        }
        
    }


}