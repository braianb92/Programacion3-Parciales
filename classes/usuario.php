<?php

namespace usuario;

class Usuario{
    public $id;
    public $email;
    public $clave;

    public function __construct($_id,$_email,$_clave){
        $this->id = $_id;
        $this->email = $_email;
        $this->clave = $_clave;
    }
}