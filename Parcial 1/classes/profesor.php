<?php

namespace profesor;

class Profesor{
    public $legajo;
    public $nombre;
    public $foto;

    public function __construct($_legajo,$_nombre,$_foto){
        $this->legajo = $_legajo;
        $this->nombre = $_nombre;
        $this->foto = $_foto;
    }
}