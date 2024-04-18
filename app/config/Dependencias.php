<?php

namespace config;

class Dependencias
{
    static function rutas()
    {
        define('SERVER', "http://backend.local/");
        define('DEP_IMG', SERVER . "public/img/");
        define('DEP_JS', SERVER . "public/js/");
        define('DEP_CSS', SERVER . "public/css/");

        define('DIRECTORIO', array(
            'home' => 'view/home.view',
            'error' => 'view/error.view',
            'login' => 'view/login/login.view',
            'insertar' => 'view/insertar.view'
        ));
    }
}
?>