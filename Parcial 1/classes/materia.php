<?php

namespace materia;

class Materia{
    public $id;
    public $nombre;
    public $cuatrimestre;


    public function __construct($_id,$_nombre,$_cuatrimestre){
        $this->id = $_id;
        $this->nombre = $_nombre;
        $this->cuatrimestre = $_cuatrimestre;
    }
}