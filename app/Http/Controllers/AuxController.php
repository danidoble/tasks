<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuxController extends Controller
{
    public static function diffForHumans($date) {
        $dia = explode("-", $date, 3);
        $year = $dia[0];
        $month = (string)(int)$dia[1];
        $day = (string)(int)$dia[2];

        $dias = array("domingo","lunes","martes","mi&eacute;rcoles" ,"jueves","viernes","s&aacute;bado");
        $tomadia = $dias[intval((date("w",mktime(0,0,0,$month,$day,$year))))];

        $meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");

        return $tomadia.", ".$day." de ".$meses[$month]." de ".$year;
    }
    public static function dateFormats($date=null,$sum=false,$res=false,$num=0){
        $time=[];
        if($date === null){
            $date=date('Y-m-d H:i:s');
        }
        //sumar o restar fechas, solo dias. modificar si requiere mas Ej. month,year,etc.
        if($sum === true || $res === true){
            if($sum){
                $symbol='+';
            }
            if($res){
                $symbol='-';
            }
            $dateOpe = strtotime ( $symbol.$num.' day' , strtotime ( $date ) ) ;
            $date = date ( 'Y-m-d H:i:s' , $dateOpe );
        }
        $str=strtotime($date);
        $time["UTC"] = date("Y-m-d\TH:i:s.vP",$str);
        $time["UTCv2"] = date("Y-m-d\TH:i:s.vO",$str);
        $time["mysql"] = date("Y-m-d H:i:s",$str);
        $time["slashes"] = date("d/m/Y",$str);//'26/06/2020'
        $time["formatted"] = self::diffForHumans(date("Y-m-d H:i:s",$str));;
        $time["custom"] = (object) [
            "date" => date("Y-m-d",$str),
            "year" => date("Y",$str),
            "time" => date("H:i:s",$str),
        ];

        return (object) $time;
    }
}
