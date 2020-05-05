<?php

namespace materiaController;

include_once './classes/response.php';
include_once './classes/data.php';

use response\Response;
use data\Data;

class MateriaController{

    //PUNTO 6
    //Retorna la lista de materias
    public static function GetAll(){
        $filePath = './files/materias.json';
        $response = new Response();
        $materias = Data::readAllJSON($filePath);

        if(isset($materias)){ 
            
            foreach ($materias as $materia) {
                array_push($response->data,$materia);
            }

            return $response;
        }
        else{
            $response->status = 'fail';
            return $response;
        }
    }

    //Retorna la materia segun el id.
    public static function GetMateria($id){
        $filePath = '/files/materias.json';
        $response = new Response();
        $materias = Data::readAllJSON($filePath);

        if(isset($materias)){
            
            foreach ($materias as $materia) {

                if($materia->id == $id){
                    $response->data = $materia;
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

    //PUNTO 3
    //Registra una materia.
    public static function addMateria($materia){
        $filePath = './files/materias.json';
        $response = new Response();

        if(isset($materia)){
            Data::saveJSON($materia,$filePath);
            return $response;
        }
        else{
            $response->status = 'fail';
            return $response;
        }       
    }

    
}