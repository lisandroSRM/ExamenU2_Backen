<?php

namespace controller;

use model\TablaCarros;
use model\TablaPersona;

require_once realpath('.../../vendor/autoload.php');



class Personas
{
    public static function obtener_datos()
    {
        $persona = new TablaPersona();
        echo json_encode($persona->consulta()->first());
    }
    public static function obtener_datos_elemento(){
        $persona = new TablaPersona();
        return $persona->consulta()->where('nombre', 'cristo')->where('edad', '23')->all();
    }
    public static function contar_datos(){
        $persona = new TablaPersona();
        return $persona->count(['*'])->all();
    }
    public static function limite_datos(){
        $persona = new TablaPersona();
        return $persona->consulta()->limit('15', '1')->all();
    }
    public static function max_datos(){
        $persona = new TablaPersona();
        return $persona->max(['edad'])->all();
    }
    public static function min_datos(){
        $persona = new TablaPersona();
        return $persona->min(['edad'])->all();
    }
    public static function sum_datos(){
        $persona = new TablaPersona();
        return $persona->sum(['edad'])->all();
    }
    public static function avg_datos(){
        $persona = new TablaPersona();
        return $persona->avg(['edad'])->all();
    }
    public static function like_datos() {
        $persona = new TablaPersona();
        return $persona->consulta()->where('sexo','')->like('F')->all();
    }    
    public static function insertar_datos()
    {
        $persona = new TablaPersona();
        echo json_encode($persona->insercion(['nombre'=>'MArlon', 'edad'=>21, 'sexo'=>'Masculino']));
    }
    public static function actualizar_datos(){
        $persona = new TablaPersona();
        echo json_encode($persona->actualizar(['nombre'=>'Cristian', 'edad'=> 27])->where('id_persona', '2'));
    }
    public static function eliminar_datos(){
        $persona = new TablaPersona();
        echo json_encode($persona->eliminar()->where('nombre', 'Warren'));
    }
}

?>