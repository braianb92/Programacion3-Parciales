<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Materia;
use App\Models\Inscripto;
use App\Utils\ValidModel;
use App\Utils\CustomResponse;
use App\Utils\Auth;
use App\Controllers\UsersController;

class InscriptosController {

    //PUNTO 6
    //SOLO ALUMNO
    public function inscribir(Request $request, Response $response, $args)
    {   
        $rta = CustomResponse::unauthorizedResponse();
        $headers = getallheaders();
        $obj = $request->getParsedBody();

        $id = Auth::idFromToken($headers['token']);
        $materia = Materia::find($args['id']);

        if(UsersController::isAlumno($id) && $materia){         
            $entity = new Inscripto;
            $entity->alumno_id = Auth::idFromToken($headers['token']);
            $entity->materia_id = $materia->id;
            $entity->date = date_create();;

            if($materia->vacantes >= 1){   
                $materia->vacantes--;
                $materia->save();
                $rta = json_encode(array("success" => $entity->save()));
            }
        }

        $response->getBody()->write($rta);

        return $response;
    }

}