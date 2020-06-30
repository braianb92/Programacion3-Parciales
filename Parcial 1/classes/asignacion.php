<?php

namespace asignacion;

class Asignacion{
    public $id;
    public $idMateria;
    public $legajoProfesor;
    public $turno;

    public function __construct($_id,$_idMateria,$_legajoProfesor,$_turno){
        $this->id = $_id;
        $this->idMateria = $_idMateria;
        $this->legajoProfesor = $_legajoProfesor;
        $this->turno = $_turno;
    }
}