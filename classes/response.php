<?php

namespace response;

class Response{
    public $status;
    public $data;

    public function __construct()
    {
        $this->status = 'success';
        $this->data = array();
    }

    //Devuelve un JSON ENCODE fail status response con un mensaje customizado en el data.
    public static function failResponse($message){
        $response = new response();
        $response->status = 'fail';
        array_push($response->data, $message);
        return json_encode($response);
    }
}