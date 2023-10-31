<?php
//Importamos los archivos necesarios
require '../classes/crudLugar.php';
require '../config/configdb.php';
//Creamos un nuevo objeto de la clase CrudLugar
    $crud = new CrudLugar(HOST, USUARIO, PASSWORD, BASEDATOS);
// Extraemos el valor de la IP pasada por URL
    $ip = $_GET["ip"];
    echo "Quiero borrar: ".$ip;
// Usamos un método del objeto para buscar el lugar asociado a esa IP
    $result = $crud->buscarLugar($ip);
// Si la consulta nos devuelve alguna fila..
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lugar = $row["lugar"];
        $descripcion = $row["descripcion"];
    }
    else{
        $lugar = 'No hay coincidencias';
        $descripcion  =  'No hay coincidencias';
}
