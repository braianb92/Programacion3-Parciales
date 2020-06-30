<?php
include_once './vendor/autoload.php';

//INCLUDES
include_once './classes/response.php';
include_once './classes/usuario.php';
include_once './classes/materia.php';
include_once './classes/profesor.php';
include_once './classes/asignacion.php';

include_once './controllers/usuarioController.php';
include_once './controllers/materiaController.php';
include_once './controllers/profesorController.php';
include_once './controllers/asignacionController.php';

//USE
use response\Response;
use usuario\Usuario;
use materia\Materia;
use profesor\Profesor;
use asignacion\Asignacion;

use usuarioController\UsuarioController;
use materiaController\MateriaController;
use profesorController\ProfesorController;
use asignacionController\AsignacionController;

session_start();

$queryParam = $_SERVER['QUERY_STRING'];

$method = $_SERVER['REQUEST_METHOD'];

$path = $_SERVER['PATH_INFO'] ?? '';

switch ($method) {

    case 'POST':
        switch (strtolower($path)) {
            
            //PUNTO 1 - REGISTRO
            case '/usuario':

                $email = $_POST['email']?? "";
                $clave = $_POST['clave']?? "";

                if($email != "" && $clave != ""){

                    $user = new Usuario(time(),$email,$clave);
                    $response = UsuarioController::register($user);
                    echo json_encode($response);
                }
                else{
                    echo Response::failResponse('Bad Request');
                }

                break;

            //PUNTO 2 - LOGIN
            case '/login':
                if(isset($_POST['email']) && isset($_POST['clave'])){

                    $response = UsuarioController::login($_POST['email'],$_POST['clave']);
                    echo json_encode($response);
                }
                else{
                    echo Response::failResponse('Bad Request');
                }
                break;
            
            default:
                echo Response::failResponse('Path Not Found');
                break;
            
            //PUNTO 3 - MATERIA (AUTENTICADO)
            case "/materia":
                $token = validTokenFromHeaders(getallheaders());
                $user = UsuarioController::validUser($token);

                $nombre = $_POST['nombre']?? "";
                $cuatrimestre = $_POST['cuatrimestre']?? "";

                if($token != false && $user != false){
                    if($nombre != "" && $cuatrimestre != ""){

                        $materia = new Materia(time(),$nombre,$cuatrimestre);
                        $response = MateriaController::addMateria($materia);
                        echo json_encode($response);
                    }
                    else{
                        echo Response::failResponse('Bad Request');
                    }
                }
                else{
                    echo Response::failResponse('Not Authorized');
                }                         
                break;
            
            //PUNTO 4 - PROFESOR (AUTENTICADO)
            case "/profesor":
                $token = validTokenFromHeaders(getallheaders());
                $user = UsuarioController::validUser($token);

                $nombre = $_POST['nombre']?? "";
                $legajo = $_POST['legajo']?? "";
                $imagen = $_FILES['imagen']?? "";

                if($token != false && $user != false){
                    if($nombre != "" && $legajo != "" && $imagen != ""){

                        ProfesorController::uploadFile($_FILES,'imagen');
                        $profesor = new Profesor($legajo,$nombre,$imagen['name']);
                        $response = ProfesorController::addProfesor($profesor);
                        echo json_encode($response);
                    }
                    else{
                        echo Response::failResponse('Bad Request');
                    }
                }
                else{
                    echo Response::failResponse('Not Authorized');
                }                         
                break;

            //PUNTO 5 - ASIGNACION (AUTENTICADO)
            case "/asignacion":
                $token = validTokenFromHeaders(getallheaders());
                $user = UsuarioController::validUser($token);

                $idMateria = $_POST['id']?? "";
                $legajo = $_POST['legajo']?? "";
                $turno = $_POST['turno']?? "";

                if($token != false && $user != false){
                    if($idMateria != "" && $legajo != "" && $turno != ""){

                        $asignacion = new Asignacion(time(),$idMateria,$legajo,$turno);
                        $response = AsignacionController::addAsignacion($asignacion);
                        echo json_encode($response);
                    }
                    else{
                        echo Response::failResponse('Bad Request');
                    }
                }
                else{
                    echo Response::failResponse('Not Authorized');
                }                         
                break;
        }
        break;

    case 'GET':
        switch (strtolower($path)) {

            //PUNTO 6 - LISTADO MATERIAS (AUTENTICADO)
            case '/materia':
                $token = validTokenFromHeaders(getallheaders());
                $user = UsuarioController::validUser($token);

                if($token != false && $user != false){

                    $response = MateriaController::GetAll();
                    echo json_encode($response);                            
                }
                else{
                    echo Response::failResponse('Not Authorized');
                }
                    break;
            
            //PUNTO 7 - LISTADO PROFESORES (AUTENTICADO)
            case '/profesor':
                $token = validTokenFromHeaders(getallheaders());
                $user = UsuarioController::validUser($token);

                if($token != false && $user != false){

                    $response = ProfesorController::GetAll();
                    echo json_encode($response);                            
                }
                else{
                    echo Response::failResponse('Not Authorized');
                }
                break;

             //PUNTO 8 - LISTADO ASIGNACIONES (AUTENTICADO)
            case '/asignacion':
                $token = validTokenFromHeaders(getallheaders());
                $user = UsuarioController::validUser($token);

                if($token != false && $user != false){

                    $response = AsignacionController::GetAll();
                    echo json_encode($response);                            
                }
                else{
                    echo Response::failResponse('Not Authorized');
                }
                break;
                 
            default:
                echo Response::failResponse('Path Not Found');
                break;         
        }
    break;
    
    default:
        echo Response::failResponse('Method Not Allowed');
        break;
}

//Recibe todos los headers y valida que exista el token. Si no existe, devuelve false.
function validTokenFromHeaders($headers){

    if(isset($headers['token'])){
        return $headers['token'];
    }
    else{
        return false;
    }
}