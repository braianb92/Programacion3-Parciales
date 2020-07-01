<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\User;
use App\Utils\ValidModel;
use App\Utils\CustomResponse;
use App\Utils\Auth;

class UsersController {

    //PUNTO 1
    public function add(Request $request, Response $response, $args)
    {
        $rta = CustomResponse::badRequestResponse();
        $obj = $request->getParsedBody();

        if(ValidModel::isUserModel($obj)){
            $validUser = true;

            $user = new User;
            $user->email = $obj['email'];
            $user->nombre = $obj['nombre'];
            $user->clave = $obj['clave'];
            $user->tipo_id = UsersController::tipoId($obj['tipo']); 
            $user->legajo = intval($obj['legajo']);

            $users = User::all();
            foreach ($users as $existingUser) {
                if($existingUser->email == $user->email || $existingUser->legajo == $user->legajo){
                    $validUser = false;
                    $rta = CustomResponse::failResponse('El usuario ya existe!');
                }
            }

            if($validUser){
                $rta = json_encode(array("success" => $user->save()));
            }
        }

        $response->getBody()->write($rta);

        return $response;
    }

    //PUNTO 2
    public function login(Request $request, Response $response, $args)
    {
        $rta = CustomResponse::unauthorizedResponse();
        $obj = $request->getParsedBody();

        if(ValidModel::isLoginModel($obj)){
            $user = new User;
            $user->email = $obj['email'];
            $user->clave = $obj['clave'];
            
            $userServer = User::where('email', $user->email)->first();

            if($userServer && ($user->clave === $userServer->clave)){

                $rta = json_encode(array('token' => Auth::encode($userServer)));
            }

        }

        $response->getBody()->write($rta);

        return $response;
    }

    //Devuelve el id segun el tipo en formato string.
    public static function tipoId ($strTipo) : int{
        if(isset($strTipo)){
            
            switch (strtolower($strTipo)) {
                case 'admin':
                    return 3;
                    break;
                case 'alumno':
                    return 1;
                    break;
                case 'profesor':
                    return 2;
                    break;
                default:
                    return false;
                    break;
            }
        }

        return false;
    }

    //Recibe id y se fija si es admin o no.
    public static function isAdmin($id){
        if(isset($id)){
            $user = User::where('id', $id)->first();
            return ($user->tipo_id == 3)?true:false;
        }
        return false;
    }

    //Recibe id y se fija si es alumno o no.
    public static function isAlumno($id){
        if(isset($id)){
            $user = User::where('id', $id)->first();
            return ($user->tipo_id == 1)?true:false;
        }
        return false;
    }

    //Recibe id y se fija si es profesor o no.
    public static function isProfesor($id){
        if(isset($id)){
            $user = User::where('id', $id)->first();
            return ($user->tipo_id == 2)?true:false;
        }
        return false;
    }
}