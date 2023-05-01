<?php
namespace App\Utils;

use Carbon\Carbon;

class Utils {

    static function FormatDate($string)
    {
        $firstArray = str_replace("DEL", "", $string);
        $secondArray = str_replace("DE", "", $firstArray);
        $pieces = explode(" ", $secondArray);
        $pieces = array_diff($pieces, array(''));
        $pieces  = array_values($pieces);        
        $month = 0;
        $arrayMonths = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
        
        if (($key = array_search(strtoupper($pieces[1]), $arrayMonths)) !== false) {

            $month = $key;
        }

        $date = Carbon::create($pieces[2], $month + 1, $pieces[0]);
        return $date->toDateString();
    }
}


