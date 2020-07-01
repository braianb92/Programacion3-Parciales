<?php

namespace App\Utils;

class ValidModel {
    

    public static function isUserModel($data){
        if(isset($data)){

            $email = $data['email']??false;
            $nombre = $data['nombre']??false;
            $clave = $data['clave']??false;
            $tipo = $data['tipo']??false;
            $legajo = $data['legajo']??false;

            if($email != false && $nombre != false && $clave != false 
                && $tipo != false && $legajo != false
                && (intval($legajo) >= 1000 && intval($legajo) <= 2000)){
                return true;
            }
        }

        return false;
    }

    public static function isLoginModel($data){
        if(isset($data)){

            $email = $data['email']??false;
            $clave = $data['clave']??false;

            if($email != false && $clave != false){
                return true;
            }
        }

        return false;
    }

    public static function isMateriaModel($data){
        if(isset($data)){

            $materia = $data['materia']??false;
            $cuatrimestre = $data['cuatrimestre']??false;
            $vacantes = $data['vacantes']??false;
            $profesor = $data['profesor']??false;

            if($materia != false && $cuatrimestre != false
                && $vacantes != false && $profesor != false){
                return true;
            }
        }

        return false;
    }

    public static function isInscriptoModel($data){
        if(isset($data)){

            $alumno_id = $data['alumno_id']??false;
            $materia_id = $data['materia_id']??false;
            $date = $data['date']??false;

            if($alumno_id != false && $alumno_id != false && $date != false){
                return true;
            }
        }

        return false;
    }

}