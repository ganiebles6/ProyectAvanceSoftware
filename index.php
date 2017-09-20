<?php

if (!isset($_REQUEST['c'])) {

    require_once 'Controlador/Controlador.php';
    $controller = new Controlador();
    $controller->IndexDefault();
} else {

    //$controller = strtolower($_REQUEST['c']);
    $accion = isset($_REQUEST['a']) ? $_REQUEST['a'] : 'index';
    require_once 'Controlador/Controlador.php';
    $controller = new Controlador();

    call_user_func(array($controller, $accion));
}

