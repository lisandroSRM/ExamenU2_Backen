<?php 
    namespace controller;
    use config\Conexion;
    use PDO;
    require_once realpath('.../../vendor/autoload.php');

    class PERSONA{
        public static function consultaDatos(){
            $consulta = Conexion::obtener_conexion()->prepare("SELECT * FROM t_personas");
            if(!$consulta->execute()){
                echo "Error al realizar la consulta";
            }else{
                $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
                print_r($datos);
            }
        }

        private static function consultaId($id){
            $consulta = Conexion::obtener_conexion()->prepare("SELECT * FROM t_personas WHERE id=:id");
            if($consulta->execute($id)){
                $datos = $consulta->fetch(PDO::FETCH_ASSOC);
            }else{
                $datos = [];
            }
            return $datos;
        }

        public static function agregarDatos($datos){
            $insercion = Conexion::obtener_conexion()->prepare("INSERT INTO t_personas(nombre,apellidoPaterno,apellidoMaterno,correo) VALUES (:nombre,:apellidoPaterno,:apellidoMaterno,:correo)");
            if($insercion->execute($datos)){
                echo json_encode([1,"Agregaste los datos correctamente"]);
            }else{
                echo json_encode([0, "Error al agregar los datos"]);
            }
        }
        public static function actualizarDatos($datos){
            $datos_guardados = self::consultaId(['id'=>$datos['id']]);
            $datos_guardados['nombre'] = array_key_exists('nombre', $datos) ? $datos['nombre'] : $datos_guardados['nombre'];
            $datos_guardados['apellidoPaterno'] = array_key_exists('apellidoPaterno',$datos) ? $datos['apellidoPaterno'] : $datos_guardados['apellidoPaterno'];
            $datos_guardados['apellidoMaterno'] = array_key_exists('apellidoMaterno', $datos) ? $datos['apellidoMaterno'] : $datos_guardados['apellidoMaterno'];
            $datos_guardados['correo'] = array_key_exists('correo',$datos) ? $datos['correo'] : $datos_guardados['correo'];

            $actualizar = Conexion::obtener_conexion()->prepare("UPDATE t_personas SET nombre=:nombre, apellidoPaterno=:apellidoPaterno, apellidoMaterno=:apellidoMaterno, correo=:correo WHERE id=:id");

            if($actualizar->execute($datos_guardados)){
                echo json_encode([1, "Actualizacion exitosa"]);
            }else{
                echo json_encode([0, "Error al actualizar"]);
            }
        }
        public static function eliminarDatos($id){
            $eliminar = Conexion::obtener_conexion()->prepare("DELETE FROM t_personas WHERE id=:id");
            if($eliminar->execute($id)){
                echo json_encode([1, "Eliminacion exitosa"]);
            }else{
                echo json_encode([0, "Error al eliminiar"]);
            }
        }
    }

?>