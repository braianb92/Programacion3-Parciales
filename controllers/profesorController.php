<?php

namespace profesorController;

include_once './classes/response.php';
include_once './classes/data.php';

use response\Response;
use data\Data;

class ProfesorController{

    //PUNTO 7
    //Retorna la lista de profesores
    public static function GetAll(){
        $filePath = './files/profesores.json';
        $response = new Response();
        $profesores = Data::readAllJSON($filePath);

        if(isset($profesores)){ 
            
            foreach ($profesores as $profesor) {
                array_push($response->data,$profesor);
            }

            return $response;
        }
        else{
            $response->status = 'fail';
            return $response;
        }
    }

    //Retorna el profesor segun el id.
    public static function GetProfesor($id){
        $filePath = '/files/profesores.json';
        $response = new Response();
        $profesores = Data::readAllJSON($filePath);

        if(isset($profesores)){
            
            foreach ($profesores as $profesor) {

                if($profesor->id == $id){
                    $response->data = $profesor;
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

    //PUNTO 4
    //Registra un profesor.
    public static function addProfesor($profesor){
        $filePath = './files/profesores.json';
        $response = new Response();

        if(isset($profesor)){
            $profesores = Data::readAllJSON($filePath);

            foreach ($profesores as $existingProfesor) {
               if($existingProfesor->legajo == $profesor->legajo)
                    $response->status = 'Ya existe un profesor con ese legajo';
                    return $response;
            }

            Data::saveJSON($profesor,$filePath);
            return $response;
        }
        else{
            $response->status = 'fail';
            return $response;
        }       
    }

    public static function uploadFile($filePost,$propertyName){

        return Data::saveFile($filePost,$propertyName,false);
    }

    
}