<?php
namespace controller;
use config\Conexion;
use PDO;

require_once realpath('.../../vendor/autoload.php');
class CRUD
{

    function __construct($tabla)
    {
        $this->tabla = $tabla;
        $consulta = Conexion::obtener_conexion()->prepare("DESCRIBE $this->tabla");
        $consulta->execute();
        $campos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $atributos = [];
        foreach($campos as $campo){
            array_push($atributos, $campo['Field']);
        }
        $this->atributos = $atributos;
    }

    private function obtener_campos($tabla){
        $consulta = Conexion::obtener_conexion()->prepare("DESCRIBE $tabla");
        $consulta->execute();
        $campos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $atributos = [];
        foreach($campos as $campo){
            array_push($atributos, $campo['Field']);
        }
        return $atributos;
    }

    public function consulta()
    {
        $consulta = Conexion::obtener_conexion()->prepare("SELECT * FROM $this->tabla");
        if ($consulta->execute()) {
            $data = $consulta->fetchAll(PDO::FETCH_ASSOC);
            echo print_r($this->atributos);
        } else {
            echo "error al consulta";
        }
    }
    private function consulta_id($id)
    {
        $consulta = Conexion::obtener_conexion()->prepare("SELECT * FROM usuarios WHERE id_persona=:id_persona");
        if ($consulta->execute($id)) {
            $data = $consulta->fetch(PDO::FETCH_ASSOC);
        } else {
            $data = [];
        }
        return $data;
    }
    public function insercion($data)
    {
        $datos_tabla = implode(",", array_keys($data));
/*         echo print_r($datos_tabla);*/        
        $datos_values = ":" . implode(", :", array_keys($data));
        /* echo print_r($datos_values); */


        $consulta = Conexion::obtener_conexion()->prepare("INSERT INTO $this->tabla ($datos_tabla) VALUES ($datos_values)");
        if ($consulta->execute($data)) {
            echo json_encode([1, "Insercion completa"]);
        } else {
            echo json_encode([0, "Error al insertar"]);
        }
    }
    public function actualizar($data)
    {
        $datos_actuales = self::consulta_id(['id_persona' => $data['id_persona']]);
        $datos_actuales['nombre'] = array_key_exists('nombre', $data) ? $data['nombre'] : $datos_actuales['nombre'];
        $datos_actuales['edad'] = array_key_exists('edad', $data) ? $data['edad'] : $datos_actuales['edad'];
        $datos_actuales['sexo'] = array_key_exists('sexo', $data) ? $data['sexo'] : $datos_actuales['sexo'];

        $datos_tabla = implode(",", array_keys($datos_actuales));
        $datos_values = ":" . implode(", :", array_keys($datos_actuales));

        $consulta = Conexion::obtener_conexion()->prepare("UPDATE $this->tabla SET $datos_tabla = $datos_values WHERE id_persona=:id_persona");
        if ($consulta->execute($datos_actuales)) {
            echo json_encode([1, "Actualizacion completa"]);
        } else {
            echo json_encode([0, "Error al actualizar"]);
        }
    }
    public function eliminar($id)
    {
        $consulta = Conexion::obtener_conexion()->prepare("DELETE FROM usuarios WHERE id_persona= :id_persona");
        if ($consulta->execute($id)) {
            echo json_encode([1, "Eliminacion completa"]);
        } else {
            echo json_encode([0, "Error al eliminar"]);
        }
    }
}
?>