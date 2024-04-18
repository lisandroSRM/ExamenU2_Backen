<?php

namespace config;
require_once realpath('./vendor/autoload.php');
use config\Dependencias;
class Route
{
    static function vista()
    {
        Dependencias::rutas();   
        $vista = isset($_REQUEST['view']) ? $_REQUEST['view'] : 'home';
        if (array_key_exists($vista, DIRECTORIO)) {
            require_once DIRECTORIO[$vista] . '.php';
        } else {
            require_once DIRECTORIO['error'] . '.php';
        }
    }
}

?>