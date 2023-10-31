<?php
require '../classes/visita.php';
require '../classes/crudJesuita.php';
require '../config/configdb.php';

    $visita = new Visita(HOST, USUARIO, PASSWORD, BASEDATOS);
    $crudJ = new CrudJesuita(HOST,USUARIO,PASSWORD,BASEDATOS);
    $accion = $_POST["accion"];

    if ($accion === "Visitar") {
        $nombre = $_POST["nombre"];
        $firma = $_POST["firma"];
        $lugar = $_POST["lugar"];

        if ($crudJ->verificarJesuita($nombre,$firma)) {
            $resultado = $visita->hacerVisita($nombre, $lugar,$firma);
            echo $resultado;
            header("Refresh:2 ;url=listar.php"); // Esperar 2 segundos y luego redirigir al listado de visitas
        } else {
            echo "La firma no pertenece a ese jesuita.";
        }
    }
    unset($crudJ); //ESTO ES PARA LLAMAR AL DESTRUCTOR DE LA CLASE, EN ESTE CASO PARA QUE CIERRE LA CONEXION
    unset($visita);