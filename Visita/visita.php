<?php
// Importamos los archivos necesarios...
require '../config/configdb.php';
require '../classes/visita.php';
require '../classes/crudJesuita.php';
require '../classes/crudLugar.php';
//Creamos los objetos necesarios para llevar a cabo la visita
$crudJ = new CrudJesuita(HOST, USUARIO, PASSWORD, BASEDATOS); //Conecta con la base de datos
$crudL = new CrudLugar(HOST,USUARIO,PASSWORD,BASEDATOS);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VISITAR</title>
    <link rel="stylesheet" type="text/css" href="../assets/style.css">
</head>
<body>
<h1>VISITA</h1>
<form method="POST" action="procesarForm.php" id="alta-form">
    <label for="nombre">Quién eres?</label>
    <select id="nombre" name="nombre">
        <?php
        // Accedemos al método que nos permite listar los jesuitas
        $result = $crudJ->listarJesuitas();
        // Recorremos el listado de jesuitas que nos ha devuelvo la BD mientras incluimos en un option cada uno de ellos
        while($row = $result->fetch_assoc()){//Extrae cada una de las filas del resultado de la consulta
            echo "<option value= '".$row["nombre"]."'>".$row["nombre"]."</option>";
        }
        ?>
    </select>

    <label for="firma">Cuál es tu firma?</label>
    <select id="firma" name="firma">
        <?php
        // Accedemos al método que nos permite listar las firmas
        $result = $crudJ->listarFirmas();
        // Recorremos el listado de firmas que nos ha devuelto la BD mientras incluimos en un option cada uno de ellos
        while($row = $result->fetch_array()) {
            echo "<option value='" . $row["firma"] . "'>" . $row["firma"] . "</option>";
        }
        ?>
    </select>

    <label for="firma">Que lugar te gustaría visitar:</label>
    <select id="firma" name="lugar">
        <?php
        // Acedemos al meetodo que nos permite listar todos los nombres de todos los lugares
        $result = $crudL->nombreLugares();
        // Recorremos el listado de nombres de lugares que nos ha devuelto la BD mientras incluimos en un option cada uno de ellos
        while($row = $result->fetch_array()){
            echo "<option value='".$row["lugar"]."'>".$row["lugar"]."</option>";
        }
        ?>
    </select>
    <input type="submit" name="accion" value="Visitar">
</form>
<!--Boton que nos permite navegar hacia atrás en la web-->
<a href="main.html" id="volver">VOLVER</a>
</body>
</html>