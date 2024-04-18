<?php

    namespace controller;
    use model\TablaAlumnos;
    
    require_once realpath(".../../vendor/autoload.php");

    class Alumnos{
        public static function obtener_datos(){
            $alumno = new TablaAlumnos(); 
            echo json_encode($alumno->consulta());
        }
        public static function insertar_datos(){
            $alumno = new TablaAlumnos();
            echo json_encode($alumno->insercion(['nombre'=>'Lisandro', 'apellidoMaterno'=>'Ramirez', 'apellidoPaterno'=>'Solis', 'edad'=>21, 'sexo'=>'Masculino', 'id_alumno'=>'']));
        }
        public static function actualizar_datos(){
            $alumno = new TablaAlumnos();
            echo json_encode($alumno->actualizar(['nombre'=>'Salvador', 'apellidoMaterno'=>'Talabera', 'id_alumno'=>2]));
        }
        public static function eliminar_datos(){
            $alumno = new TablaAlumnos();
            echo json_encode($alumno->eliminar(['id_alumno'=>2]));
        }
    }

?>  