<?php

namespace App\Utils;

use \Firebase\JWT\JWT;

class Auth{

    //Hace un encode del JWT junto con la informacion
    //no sensible del usuario. Retorna un JWT
    public static function encode($entity){
        $key = "prog3-parcial2";
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
        $key = "prog3-parcial2";

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

    public static function idFromToken($jwt){

        try {
            $object = Auth::decode($jwt);
            return intval($object->id);
        } catch (\Throwable $th) {
            return false;
        }
    }

    //Recibe el token por header y valida que exista. Si no existe o no es valido, devuelve false.
    public static function validTokenFromHeaders($header){

        if(isset($header['token'])){
            $token = $header['token'];
            $valid = Auth::decode($token);
            if($valid != false){
                return true;
            }
        }
        
        return false;
}

    public static function hashPass(string $pass) : string{

        return password_hash($pass, PASSWORD_DEFAULT);
    }

    public static function verifyPass(string $pass, string $hash) : bool{

        if(password_verify ($pass, $hash)){
            return true;
        }

        return false;
    }


}