<?php

namespace App\Utils;

class CustomResponse{
    public $success;
    public $status;

    public function __construct()
    {
        $this->success = true;
        $this->status = 200;
    }

    public static function okCreatedResponse(){
        $response = new CustomResponse();
        $response->status = '201 Created';
        return json_encode($response);
    }

    public static function failResponse($message){
        $response = new CustomResponse();
        $response->success = false;
        $response->status = $message;
        return json_encode($response);
    }


    public static function badRequestResponse(){
        $response = new CustomResponse();
        $response->success = false;
        $response->status = '400 Bad Request';
        return json_encode($response);
    }

    public static function notFoundResponse(){
        $response = new CustomResponse();
        $response->success = false;
        $response->status = '404 Not Found';
        return json_encode($response);
    }

    public static function unauthorizedResponse(){
        $response = new CustomResponse();
        $response->success = false;
        $response->status = '401 Unauthorized';
        return json_encode($response);
    }

}