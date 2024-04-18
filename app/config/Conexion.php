<?php
namespace config;

use Dotenv\Dotenv;
use PDO;
use PDOException;

$dotenv = Dotenv::createImmutable('./');
$dotenv->load();
define('SERVIDOR', $_ENV['HOST']);
define('USER', $_ENV['USUARIO']);
define('DB', $_ENV['DBNAME']);
define('PASS', $_ENV['PASSWORD']);
define('PUERTO', $_ENV['PUERTO']);
class Conexion
{
    private static $conexion;

    private static function abrir_conexion()
    {
        if (!isset(self::$conexion)) {
            try {
                self::$conexion = new PDO('mysql:host=' . SERVIDOR . ';dbname=' . DB, USER, PASS);
                self::$conexion->exec('SET CHARACTER SET utf8');
                return self::$conexion;
            } catch (PDOException $e) {
                echo "Error en la conexion: " . $e;
                die();
            }
        } else {
            return self::$conexion;
        }
    }

    public static function obtener_conexion()
    {
        $conexion = self::abrir_conexion();
        return $conexion;
    }

    public static function cerrar_conexion()
    {
        self::$conexion = null;
    }
}


/* Crud::insercion(['nombre'=>'angel','edad'=>23, 'sexo'=>'Masculino']); */
/* Crud::actualizar(['edad'=>40,'sexo'=>'Binario', 'id_persona'=>1]); */
/* Crud::eliminar(['id_persona'=>3]); */
/* function mostrar_datos(){
    $conexion = Conexion::obtener_conexion();
    $query = "SELECT * FROM usuarios";
    $stmt = $conexion->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
function agregar_datos($datos){
    $conexion = Conexion::obtener_conexion();
    $query = "INSERT INTO usuarios(nombre, edad, sexo) VALUES(:nombre, :edad, :sexo)";
    $stmt = $conexion->prepare($query);
    $stmt->bindParam(":nombre", $datos["nombre"]);
    $stmt->bindParam(":edad", $datos["edad"]);
    $stmt->bindParam(":sexo", $datos["sexo"]);
    $stmt->execute();
    return json_encode($stmt);
}

function actualizar_datos($datos){
    $conexion = Conexion::obtener_conexion();
    $query = "UPDATE usuarios SET nombre=:nombre, edad=:edad, sexo=:sexo WHERE id_persona=:id";
    $stmt = $conexion->prepare($query);
    $stmt->bindParam(":id", $datos['id_persona']);
    $stmt->bindParam(":nombre", $datos['nombre']);
    $stmt->bindParam(":edad", $datos['edad']);
    $stmt->bindParam(":sexo", $datos['sexo']);
    $stmt->execute();
    return $stmt;
}

function eliminar_datos($datos){
    $conexion = Conexion::obtener_conexion();
    $query = "DELETE FROM usuarios WHERE id_persona=:id";
    $stmt = $conexion->prepare($query);
    $stmt->bindParam(":id", $datos['id_persona']);
    $stmt->execute();
    return $stmt;
}

/* Actualizar, Eliminar y Agregar */
/* echo print_r(mostrar_datos()); */
/* agregar_datos(['nombre'=>'Axel', 'edad'=>30, 'sexo'=>'Siempre']);
echo print_r(mostrar_datos());
actualizar_datos(['id_persona'=>5, 'nombre'=>'Jorge', 'edad'=>26, 'sexo'=>'Masculino']);
echo print_r(mostrar_datos()); */
/* eliminar_datos(['id_persona'=>6]);
echo print_r(mostrar_datos()); */ 
?>
