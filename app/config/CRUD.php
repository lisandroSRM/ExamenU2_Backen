<?php
    namespace controller:
    use config\Conexion;
    use PDO;
    require_once realpath('../../vendor/autoload.php');
    class CRUD{
        public function__construct($tabla, $id_tabla){
            $this->tabla =$tabla;
            $this->id_tabla =$id_tabla;
            $this->atributos =$this->atributos_tabla;
        }
        private function atributos_tabla(){
            $consulta=Conexion::obtener_conexion()->prepare("DESCRIBE $this->tabla");
            $consulta->execute();
            $campos = $consulta->fetchAll(PDO::FETCH_ASSOC);
            $atributos = [];
            foreach($campos as $campo){
                array_push($atributos, $campo['Field']);
            }
            return $atributos;
        }
        public function consulta($seleccion = ['*']){
            $seleccion implode(',', $seleccion);
            $consulta Conexion::obtener_conexion()->prepare("SELECT $seleccion FROM $this ->tabla");
            if($Consulta->execute()){
                $data=$consulta->fetchAll(PDO::FETCH_ASSOC);
            }else{
                $data = [];
            return $data;
        }
        public function insercion($datos){
            $propiedades=implode(",", $this->atributos);
            $propiedades_key=":"implode(", :", $this->atributos);
            $consulta=Conexion::obtener_conexion()->prepare("INSERT INTO $this->tabla ($propied) VALUES ($PROPIEDADES_KEY)");
            if($consulta->execute($datos)) {
                echo json_encode([1, "Insercion correcta"]);
            }else{
                echo json_encode([0, "Error al insertar datos"]);
            }
            
        } 
        
        public function actualizar($datos) {
        $query = [];
        foreach(array_keys($datos) as $key ){
            if($this->id_tabla =! $key){ 
                array_push($query, $key. '=:'.$key);
                }
        }
        $query implode(', ',$query);
        $consulta=Conexion::obtener_conexion()
        ->prepare("UPDATE $this->tabla SET $query WHERE $this->id_tabla=: $this->id_tabla");
        if($consulta->execute($datos)){
            echo json_encode([1, "Actualizacion correcta"]);
        }else{
        echo json_encode([0, "Error en la actualizacion de datos"]);
        }
    }
    public function eliminar($id){
        $consulta = Conexion::obtener_conexion()
        ->prepare("DELETE FROM $this->tabla WHERE $this->id_tabla = :$this->id_tabla");
        if($consulta->execute($id)){
            echo json_encode([1,"eliminacion correcta"]);
        }else{
            echo json_encode([0,"Error al eliminar el dato"]);
        }
    }

?>