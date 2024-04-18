<?php
namespace config;
use config\Conexion;
use PDO;
use PDOException;

require_once realpath('.../../vendor/autoload.php');
class ORM
{
    protected $tabla;
    protected $id_tabla;
    protected $atributos;
    private $contadorWhere;
    function __construct()
    {
        $this->atributos = $this->atributos_tabla();
    }

    private function atributos_tabla(){
        try{
            $consulta = Conexion::obtener_conexion()->prepare("DESCRIBE $this->tabla");
            $consulta->execute();
            $campos = $consulta->fetchAll(PDO::FETCH_ASSOC);
            $atributos = [];
            foreach($campos as $campo){
                array_push($atributos, $campo['Field']);
            }
            return $atributos;
        }catch (PDOException $e){
            return json_encode($e);
        }
    }

    public function count($seleccion){
        try{
            $seleccion = implode(',', $seleccion);
            $this->query = "SELECT COUNT($seleccion) FROM $this->tabla";
            return $this;
        }catch(PDOException $e){
            return json_encode($e);
        }
    }
    public function limit($limite = '', $compensar = '')
    {
        try {
            if($limite === '' && $compensar === '') {
                $limite = '100';
                $query3 = $this->query;
                $this->query = "$query3 LIMIT $limite";
            } else {
                $query3 = $this->query;
                $this->query = "$query3 LIMIT $limite OFFSET $compensar";
            }
            return $this;
        } catch(PDOException $e) {
            return json_encode($e);
        }
    }
    public function max($seleccion){
        try{
            $seleccion = implode(',', $seleccion);
            $this->query = "SELECT MAX($seleccion) FROM $this->tabla";
            return $this;
        }catch(PDOException $e){
            return json_encode($e);
        }
    }
    public function min($seleccion){
        try{
            $seleccion = implode(',', $seleccion);
            $this->query = "SELECT MIN($seleccion) FROM $this->tabla";
            return $this;
        }catch(PDOException $e){
            return json_encode($e);
        }
    }
    public function sum($seleccion){
        try{
            $seleccion = implode(',', $seleccion);
            $this->query = "SELECT SUM($seleccion) FROM $this->tabla";
            return $this;
        }catch(PDOException $e){
            return json_encode($e);
        }
    }

    public function avg($seleccion){
        try{
            $seleccion = implode(',', $seleccion);
            $this->query = "SELECT AVG($seleccion) FROM $this->tabla";
            return $this;
        }catch(PDOException $e){
            return json_encode($e);
        }
    }
    public function like($valores = '') {
        try {
            $query4 = $this->query;
            $this->query = "$query4 LIKE '$valores%'";
            /* echo print_r($this->query); */
            return $this;
        } catch(PDOException $e) {
            return json_encode($e);
        }
    }    
    public function where($campo, $valor_campo, $tipo = "AND") {
        try {
            $queryFinal = $this->query;
            if ($this->contadorWhere > 0) {
                $this->query = "$queryFinal " . ($tipo != "AND" ? 'OR' : $tipo) . " $campo = '$valor_campo'";
            } else {
                if($valor_campo === ''){
                    $this->query = "$queryFinal WHERE $campo";
                }else{
                    $this->query = "$queryFinal WHERE $campo = '$valor_campo'";
                }
            }
            $this->contadorWhere++;
            return $this;
        } catch (PDOException $e) {
            return json_encode($e);
        }
    }   
    public function all(){
        try {
            $queryFinal = $this->query;
            $consulta = Conexion::obtener_conexion()->prepare($queryFinal);
            if($consulta->execute()){
                $data = $consulta->fetchAll(PDO::FETCH_ASSOC);
            }else{
                $data = [];
            }
            return $data;
        }catch (PDOException $e){
            return json_encode($e);
        }
    }
    public function first(){
        try{
            $queryFinal = $this->query;
            $consulta = Conexion::obtener_conexion()->prepare($queryFinal);
            if($consulta->execute()){
                $data = $consulta->fetch(PDO::FETCH_ASSOC);
            }else{
                $data = [];
            }
            return $data;
        }catch(PDOException $e){
            return json_encode($e);
        }
    }
    public function get(){
        try{
            $queryFinal = $this->query;
            $consulta = Conexion::obtener_conexion()->prepare($queryFinal);
            return $consulta->execute();
        }catch(PDOException $e){
            return json_encode($e);
        }
    }

    public function consulta($seleccion = ['*'])
    {
        try{
            $seleccion = implode(',', $seleccion);
            $this->query = "SELECT $seleccion FROM $this->tabla";
            return $this;
        }catch(PDOException $e){
            return json_encode($e);
        }
    }

    public function insercion($data)
    {
        try{
            $temp = array();
            foreach($this->atributos as $valor){
                if($this->id_tabla != $valor){
                    array_push($temp, $valor);
                }
            }
            $datos_tabla = implode(",", $temp);
            $datos_values = ":" . implode(", :", $temp);
            $consulta = Conexion::obtener_conexion()->prepare("INSERT INTO $this->tabla ($datos_tabla) VALUES ($datos_values)");
            return $consulta->execute($data);
            
        }catch (PDOException $e){
            return json_encode($e);
        }
    }
    public function actualizar($data)
    {
        /* $query = "";
        $contador = 0;
        foreach(array_keys($data) as $key){
            $query .= $this->id_tabla == $key ? '' : ($contador !=0 ? ','.$key.'=:'. $key : $key .'=:'. $key); 
            $contador++;
        } */
        try{
            $query2 = [];
            foreach(array_keys($data) as $key){
                if($this->id_tabla != $key){
                    array_push($query2, $key.'='."'$data[$key]'");
                }
            }
            $query2 = implode(', ', $query2);
            $this->query = "UPDATE $this->tabla SET $query2";
            return $this;
        }catch(PDOException $e){
            return json_encode($e);
        }
    }
    public function eliminar()
    {
       try{
           $this->query = "DELETE FROM $this->tabla";
           return $this;
       }catch(PDOException $e){
        return json_encode($e);
       }
    }
}
?>