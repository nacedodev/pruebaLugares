
<?php
// Importamos los archivos necesarios
require '../config/configdb.php';
require '../classes/crudLugar.php';
// Creamos un nuevo objeto de la clase CrudLugar
$crud = new CrudLugar(HOST, USUARIO, PASSWORD, BASEDATOS);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LUGARES</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<table>
    <tr>
        <td colspan="4">LUGARES <a id="add" href="alta.html"><img width="20" height="20" src="https://img.icons8.com/color/48/add--v1.png" alt="add"/></a></td>
    </tr>
    <tr>
        <td>LUGAR</td>
        <td>IP</td>
        <td>DESCRIPCION</td>
        <td>ACCIONES</td>
    </tr>
    <?php
    // Llamamos a un método del objeto para que nos devuelva una lista de todos los lugares
    $result = $crud->listarLugares();
    // Si nos devuelve alguna fila , es decir , la consulta devuelve algo...
    if(!$result->num_rows) {
        echo "<tr>";
        echo "<td colspan='3'> No hay coincidencias </td>";
        echo "</tr>";
    }else {
        // Recorremos todas las filas de array y vamos mostrando el contenido refiriendonos a el de manera asociativa
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row["lugar"]."</td>";
            echo "<td>".$row["ip"]."</td>";
            echo "<td>".($row["descripcion"] === NULL ? "vacío" : $row["descripcion"])."</td>";
            echo "<td>";
            echo '<a style="margin-right:20px" href="procesarForm.php?ip='.$row["ip"].'&accion=borrar"><img width="25" height="25" src="https://img.icons8.com/ios/50/trash--v1.png" alt="trash"/></a>';
            echo '<a href="procesarForm.php?ip='.$row["ip"].'&accion=modificar"><img width="25" height="25" src="https://img.icons8.com/external-prettycons-lineal-prettycons/49/external-marker-tools-prettycons-lineal-prettycons.png" alt="mod"/></a>';
            echo "</td>";
            echo "</tr>";
        }
    }
    // Llamamos al destructor de la clase
    unset($crud);
    ?>
</table>
<a href="../index.html" id="volver">VOLVER</a>
</body>
</html>
