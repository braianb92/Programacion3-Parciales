<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Entidad;
use App\Utils\ValidModel;
use App\Utils\CustomResponse;
use App\Utils\Auth;

class EntidadController {

    //GET ALL
    public function getAll(Request $request, Response $response, $args)
    {
        $rta = json_encode(Entidad::all());

        $response->getBody()->write($rta);

        return $response;
    }

    //GET por ID
    public function get(Request $request, Response $response, $args)
    {   
        $rta = json_encode(Entidad::find($args['id']));

        if($rta === 'null'){
            $rta = CustomResponse::notFoundResponse();
        }

        $response->getBody()->write($rta);

        return $response;
    }

    //Add con id por token.
    public function addFromToken(Request $request, Response $response, $args)
    {
        $headers = getallheaders();
        $obj = $request->getParsedBody();

        if(ValidModel::isEntidadModel($obj)){
            $entity = new Entidad;
            $entity->id_usuario = Auth::idFromToken($headers['token']);
            $entity->nombre = $obj['nombre'];
            $entity->edad = $obj['edad'];
            $rta = json_encode(array("success" => $entity->save()));
        }
        else{
            $rta = CustomResponse::badRequestResponse();
        }

        $response->getBody()->write($rta);

        return $response;
    }

     //Add
     public function add(Request $request, Response $response, $args)
     {
         $obj = $request->getParsedBody();
 
         if(ValidModel::isEntidadModel($obj)){
             $entity = new Entidad;
             $entity->id_usuario = $obj['id_usuario'];;
             $entity->nombre = $obj['nombre'];
             $entity->edad = $obj['edad'];
             $rta = json_encode(array("success" => $entity->save()));
         }
         else{
             $rta = CustomResponse::badRequestResponse();
         }
 
         $response->getBody()->write($rta);
 
         return $response;
     }

    //DELETE por ID
    public function delete(Request $request, Response $response, $args)
    {   
        $entity = Entidad::find($args['id']);    
        $rta = json_encode(array("success" => $entity->delete()));

        $response->getBody()->write($rta);

        return $response;
    }

    //UPDATE
    public function update(Request $request, Response $response, $args)
    {   

        $response->getBody()->write($rta);

        return $response;
    }

    //Register con HASH password
    public function register(Request $request, Response $response, $args)
    {
        $obj = $request->getParsedBody();

        if(ValidModel::isUserModel($obj)){
            $entity = new Entidad;
            $entity->email = $obj['email'];
            $entity->tipo = $obj['tipo'];
            $entity->password = Auth::hashPass($obj['password']);
            $rta = json_encode(array("success" => $entity->save()));
        }
        else{
            $rta = CustomResponse::badRequestResponse();
        }

        $response->getBody()->write($rta);

        return $response;
    }

    //Login con Verify HASH
    public function login(Request $request, Response $response, $args)
    {
        $rta = CustomResponse::unauthorizedResponse();
        $obj = $request->getParsedBody();

        if(ValidModel::isLoginModel($obj)){
            $entity = new Usuario;
            $entity->email = $obj['email'];
            $entity->password = $obj['password'];
            
            $entityServer = Usuario::where('email', $entity->email)->first();

            if($entityServer && Auth::verifyPass($entity->password,$entityServer->password)){

                $rta = json_encode(array('token' => Auth::encode($entityServer)));
            }

        }

        $response->getBody()->write($rta);

        return $response;
    }
}