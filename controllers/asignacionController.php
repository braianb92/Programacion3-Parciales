<?php

namespace asignacionController;

include_once './classes/response.php';
include_once './classes/data.php';

use response\Response;
use data\Data;

class AsignacionController{

    //PUNTO 8
    //Retorna la lista de asignaciones
    public static function GetAll(){
        $filePath = './files/materias-profesores.json';
        $response = new Response();
        $asignaciones = Data::readAllJSON($filePath);

        if(isset($asignaciones)){ 
            
            foreach ($asignaciones as $asignacion) {
                array_push($response->data,$asignacion);
            }

            return $response;
        }
        else{
            $response->status = 'fail';
            return $response;
        }
    }

    //Retorna la asignacion segun el id.
    public static function GetAsignacion($id){
        $filePath = '/files/materias-profesores.json';
        $response = new Response();
        $asignaciones = Data::readAllJSON($filePath);

        if(isset($asignaciones)){
            
            foreach ($asignaciones as $asignacion) {

                if($asignacion->id == $id){
                    $response->data = $asignacion;
                    return $response;
                }
            }
            
            $response->status = 'not found';
            return $response;
        }
        else{
            $response->status = 'fail';
            return $response;
        }
    }

    //PUNTO 5
    //Registra una asignacion.
    public static function addAsignacion($asignacion){
        $filePath = './files/materias-profesores.json';
        $response = new Response();

        if(isset($asignacion)){
            Data::saveJSON($asignacion,$filePath);
            return $response;
        }
        else{
            $response->status = 'fail';
            return $response;
        }       
    }

    
}