<?php

namespace data;

class Data{

    //Guarda en un JSON un array.
    public static function saveJSON($object,$filePath){

        if(isset($object)){

            $data = Data::readAllJSON($filePath);

            array_push($data,$object);
            

            $file = fopen($filePath, 'w');

            $rta = fwrite($file, json_encode($data));

            fclose($file);

            return $rta;
        }

    return false;
}

    //Lee el archivo JSON y devuelve un array.
    public static function readAllJSON($filePath){

    $file = fopen($filePath, 'r');

    $data = fread($file, filesize($filePath));
   
    fclose($file);

    if(strlen($data)>1){

        $arrayJSON = json_decode($data);

        return $arrayJSON;
    }
    
    return $emptyArray = array();
}

    //Guarda una imagen en la carpeta imagenes. Recibe un booleano para guardar con marca de agua
    public static function saveFile($filePost,$propertyName,$watermarkBool){

        if(isset($filePost) && isset($propertyName)){

            if($watermarkBool === true){
                Data::saveFileWaterMark($filePost,$propertyName);
            }
            else{

                $tmp = $filePost[$propertyName]['tmp_name'];
                $fileName = $filePost[$propertyName]['name'];
                $folder = 'imagenes/';
                move_uploaded_file($tmp, $folder.$fileName);
            }

            return true;
            
        }

        return false;
    }

    //Guarda una imagen con marca de agua.
    public static function saveFileWaterMark($filePost,$propertyName){
        
        $folder = 'imagenes/';
        $tmp = $filePost[$propertyName]['tmp_name'];
        $fileName = $filePost[$propertyName]['name'];

        $im = imagecreatefromjpeg($tmp);

        // Creacion de marca de agua
        $estampa = imagecreatetruecolor(300, 70);
        imagefilledrectangle($estampa, 0, 0, 99, 69, 0x0000FF);
        imagefilledrectangle($estampa, 9, 9, 300, 70, 0xFFFFFF);
        $im = imagecreatefromjpeg($tmp);
        imagestring($estampa, 14, 20, 20, 'Braian Baldino', 0x0000FF);
        imagestring($estampa, 12, 20, 40, '(c) Programacion III 2020', 0x0000FF);

        // Establece los márgenes para la marca de agua y obtiene el alto/ancho de la imagen de la estampa
        $margen_dcho = 10;
        $margen_inf = 10;
        $sx = imagesx($estampa);
        $sy = imagesy($estampa);

        // Fusionar la estampa con nuestra foto con una opacidad del 50%
        imagecopymerge($im, $estampa, imagesx($im) - $sx - $margen_dcho, imagesy($im) - $sy - $margen_inf, 0, 0, imagesx($estampa), imagesy($estampa), 50);

        // Guardar la imagen en un archivo y liberar memoria
        $image = imagepng($im, $folder.$fileName);
        imagedestroy($im);
        return true;
    }

}