<?php

    namespace controller;
    use model\TablaCarros;

    require_once realpath(".../../vendor/autoload.php");

    class Carros 
    {

        public static function obtener_datos(){
            $carro = new TablaCarros();
            echo json_encode($carro->consulta());
        }
        public static function insercion_datos(){
            $carro = new TablaCarros();
            echo json_encode($carro->insercion(['marca' => 'Chevrolet', 'modelo'=> 'Monza', 'color'=>'rojo', 'placa'=>'PKG8795', 'kilometraje'=>13,'id_carro'=>'']));
        }
        public static function actualizar_datos(){
            $carro = new TablaCarros();
            echo json_encode($carro->actualizar(['placa'=>'ASM2310', 'id_carro'=>1]));
        }
        public static function eliminar_datos(){
            $carro = new TablaCarros();
            echo json_encode($carro->eliminar(['id_carro'=>1]));
        }

    }

?>