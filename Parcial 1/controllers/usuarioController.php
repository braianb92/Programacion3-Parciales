<?php

namespace usuarioController;

include_once './classes/response.php';
include_once './classes/data.php';
include_once './classes/auth.php';

use response\Response;
use data\Data;
use auth\Auth;

class UsuarioController{

    //Retorna la lista de usuarios
    public static function GetAll(){
        $filePath = './files/users.json';
        $response = new Response();
        $users = Data::readAllJSON($filePath);

        if(isset($users)){ 
            
            foreach ($users as $user) {
                array_push($response->data,$user);
            }

            return $response;
        }
        else{
            $response->status = 'fail';
            return $response;
        }
    }

    //Retorna el usuario segun el id.
    public static function GetUser($id){
        $filePath = '/files/users.json';
        $response = new Response();
        $users = Data::readAllJSON($filePath);

        if(isset($users)){
            
            foreach ($users as $user) {

                if($user->id == $id){
                    $response->data = $user;
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

    //PUNTO 1
    //Registra un usuario.
    public static function register($user){
        $filePath = './files/users.json';
        $response = new Response();

        if(isset($user)){
            Data::saveJSON($user,$filePath);
            return $response;
        }
        else{
            $response->status = 'fail';
            return $response;
        }       
    }

    //PUNTO 2
    //Retorna un JWT si el usuario existe.
    public static function login($email,$clave){
        $filePath = './files/users.json';
        $response = new Response();

        if(isset($email)&&isset($clave)){
            $users = Data::readAllJSON($filePath);

            foreach ($users as $user) {

                if($user->email == $email && $user->clave == $clave){

                    $response->data = Auth::encode($user);
                    return $response;
                }
            }
            
             $response->status = 'Login Failed, User Not Found';
             return $response;
        }
    }


    //Retorna true si el usuario del token existe en el archivo.
    public static function validUser($jwt){

        $filePath = './files/users.json';
        $users = Data::readAllJSON($filePath);

        if(isset($users) && $jwt != false){

            $decodedUser = Auth::decode($jwt);

            if($decodedUser != false){

                foreach($users as $user){

                    if($user->id == $decodedUser->id && $user->email == $decodedUser->email){
                        return $user;
                    }
                   
                }
            }       
        }

        return false;
    }
}