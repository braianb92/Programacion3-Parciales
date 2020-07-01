<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Materia;
use App\Models\User;
use App\Models\Inscripto;
use App\Utils\ValidModel;
use App\Utils\CustomResponse;
use App\Utils\Auth;
use App\Controllers\UsersController;

class MateriasController {

    //PUNTO 3
    //SOLO ADMIN
    public function addMateria(Request $request, Response $response, $args)
    {   
        $rta = CustomResponse::unauthorizedResponse();
        $headers = getallheaders();
        $obj = $request->getParsedBody();

        $id = Auth::idFromToken($headers['token']);

        if(ValidModel::isMateriaModel($obj) && UsersController::isAdmin($id)){
            $entity = new Materia;
            $entity->materia = $obj['materia'];
            $entity->cuatrimestre = intval($obj['cuatrimestre']);
            $entity->vacantes = intval($obj['vacantes']);
            $entity->profesor_id = intval($obj['profesor']);
            $rta = json_encode(array("success" => $entity->save()));
        }

        $response->getBody()->write($rta);

        return $response;
    }

    //PUNTO 4
    //Alumno -> datos de materia
    //admin y profesor -> datos e inscriptos
    public function getMateria(Request $request, Response $response, $args)
    {   
        $rta = CustomResponse::unauthorizedResponse();
        $headers = getallheaders();

        $id = Auth::idFromToken($headers['token']);
        $materia = Materia::find($args['id']);

        if((UsersController::isAdmin($id) || UsersController::isProfesor($id))
            && $materia){
            
            $inscriptos = array();
            $allInsc = Inscripto::all();

            foreach ($allInsc as $inscripto) {
                if($materia->id == $inscripto->materia_id){
                    array_push($inscriptos,$inscripto);
                }
            }
            $rta = json_encode(array('materia' => $materia,'inscriptos' => $inscriptos));
        }
        
        else if(UsersController::isAlumno($id) && $materia){
            $rta = json_encode(array('materia' => $materia));
        }

        $response->getBody()->write($rta);

        return $response;
    }


    
}
