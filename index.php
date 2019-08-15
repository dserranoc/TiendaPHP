<?php

session_start();
require_once 'config/db.php';
require_once 'autoload.php';
require_once 'helpers/utils.php';
require 'config/parameters.php';
require 'views/layout/header.php';
require 'views/layout/sidebar.php';

// Conexion a la base de datos

$db = Database::connect();

function show_Error(){
    $error = new ErrorController();
    $error->index();
}
if (isset($_GET['controller'])) {
    $nombre_controlador = $_GET['controller'] . 'Controller';
} elseif(!isset($_GET['controller']) && !isset($_GET['action'])) {
    $nombre_controlador = default_controller;
} else {
    show_Error();
    exit();
}


if (isset($nombre_controlador) && class_exists($nombre_controlador)) {

    $controlador = new $nombre_controlador();

    if (isset($_GET['action']) && method_exists($controlador, $_GET['action'])) {
        $action = $_GET['action'];
        $controlador->$action();
    }elseif(!isset($_GET['controller']) && !isset($_GET['action'])) {
        $default_action = default_action;
        $controlador->$default_action();
    } else {
        show_Error();
    }
} else {
    show_Error();
}

require 'views/layout/footer.php';
