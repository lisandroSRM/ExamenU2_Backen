<?php 

    namespace controller;
    use model\TablaAnimales;

    require_once realpath(".../../vendor/autoload.php");
    
    class Animales{
        public static function obtener_datos(){
            $animal = new TablaAnimales();
            echo json_encode($animal->consulta());
        }

        public static function insercion_datos(){ //Aqui se insertan las datos a la tabla mediante la configuracion del ORM ya establecida
            $animal = new TablaAnimales();
            echo json_encode($animal->insercion(['nombre' => 'guero', 'raza'=>'pastor aleman','especie'=>'Perro', 'color'=>'blanco', 'peso'=>24.2, 'habitat'=>'Jardin','id_animal'=>'']));
        }
        public static function actualizar_datos(){ //Aqui se actualizan los datos que se desen cambiar y pide tambien un id referente a la fila que se desea cambiar
            $animal = new TablaAnimales();
            echo json_encode($animal->actualizar(['nombre'=>'tortu', 'id_animal'=>1]));
        }
        public static function eliminar_dato(){ //Aqui se elimina los datos mediante el id que se desea eliminar y así sus datos relacionados
            $animal = new TablaAnimales();
            echo json_encode($animal->eliminar(['id_animal'=>1]));
        }
    }

?>