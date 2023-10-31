<?php
require '../classes/crudLugar.php';
require '../config/configdb.php';

    $crud = new CrudLugar(HOST, USUARIO, PASSWORD, BASEDATOS);
    $accion = $_GET["accion"];

    if ($accion === "Alta") {
        $ip = $_GET["ip"];
        $lugar = $_GET["lugar"];
        $descripcion = empty($_GET["descripcion"]) ? "NULL" : "'".$_GET["descripcion"]."'";

        if (count(explode('.',$ip)) === 4) {
            $resultado = $crud->altaLugar($ip, $lugar, $descripcion);
            //header("Location: listar.php");
        } else {
            echo "IP inválida.";
        }
    } elseif ($accion === "modificar") {

        header("Location: modificacion.php?ip=".$_GET["ip"]);
    } elseif ($accion === "borrar") {

        header("Location: borrar.php?ip=".$_GET["ip"]);
    }

    // Cierra la conexión a la base de datos
    unset($crud); //ESTO ES PARA LLAMAR AL DESTRUCTOR DE LA CLASE, EN ESTE CASO PARA QUE CIERRE LA CONEXION