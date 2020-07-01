<?php

namespace App\Utils;

class Helper{

    public static function formatearFecha($strFecha, $strHora) {
        try {
       
            $time = Helper::timeArray($strHora);

            //y-m-d
            //2001-03-25
            $formatFecha = date_create($strFecha);
            date_time_set($formatFecha,intval($time['hour']),intval($time['min']),intval($time['sec']));
            $array = (array)$formatFecha;
            return $array['date'];

        } catch (\Throwable $th) {
            return false;
        }
        
    }

    public static function timeArray($str){
        $x = explode(':', $str);
        $hour = $x[0]??0;
        $min = $x[1]??0;
        $sec = $x[2]??0;

        return array('hour' => $hour,'min' => $min,'sec' => $sec);
    }
}