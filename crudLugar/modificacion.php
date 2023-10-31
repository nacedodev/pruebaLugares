<?php
//Importamos los archivos necesarios
require '../classes/crudLugar.php';
require '../config/configdb.php';
//Creamos un nuevo objeto de la clase CrudLugar
    $crud = new CrudLugar(HOST, USUARIO, PASSWORD, BASEDATOS);
// Extraemos el valor de la IP pasada por URL
    $ip = $_GET["ip"];
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>MODIFICACION</title>
    <link rel="stylesheet" type="text/css" href="../assets/style.css">
</head>
<body id="modificar-form">
<h1>Modificación del lugar</h1>
<form method="GET" action="procesarForm.php">
    <label for="ip">IP:</label>
    <input type="text" name="ip" value="<?php echo $ip; ?>">
    <label for="lugar">Lugar:</label>
    <input type="text" name="lugar" value="<?php echo $lugar; ?>"><br>

    <label for="descripcion">Descripcion:</label>
    <input type="text" name="descripcion" value="<?php echo $descripcion; ?>"><br>

    <input type="submit" name="accion" value="modificar">
</form>
<a href="listar.php" id="volver">VOLVER</a>
</body>
</html>
