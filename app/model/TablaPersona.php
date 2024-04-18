<?php 

    namespace model;
    use config\ORM;

    class TablaPersona extends ORM{
        protected $tabla = 'usuarios';
        protected $id_tabla = 'id_persona';
    }
?>