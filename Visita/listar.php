
<?php
require '../config/configdb.php';
require '../classes/visita.php';
$crud = new Visita(HOST, USUARIO, PASSWORD, BASEDATOS);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LISTADO DE VISITAS</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<h2 style="text-align: center;">LISTADO DE VISITAS</h2>
<table>
    <tr>
        <td colspan = "4">VISITAS<span style="color:rgb(128,128,128)"> (5 últimas)</span></td>
    </tr>
    <tr>
        <td>NOMBRE</td>
        <td>LUGAR</td>
        <td>FECHA - HORA</td>
    </tr>
    <?php

    $result = $crud->listarVisitas();

    if(!$result->num_rows) {
        echo "<tr>";
        echo "<td colspan='3'> No hay coincidencias </td>";
        echo "</tr>";
    }else {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row["nombre"]."</td>";
            echo "<td>".$row["lugar"]."</td>";
            echo "<td>".$row["fechaHora"]."</td>";
            echo "</tr>";
        }
    }
    // He buscado el jesuita que ha realizado más visitas y he guardado los valores de nombre y nVisitas en variables que usare más adelate
    $result = $crud->maxVisitasJesuita();
    $row = $result->fetch_assoc();

    $jesuita = $row["nombre"];
    $nVisitas = $row["total_visitas"];

    unset($crud);
    ?>
</table>
<h2 style="text-align: center; margin-top: 100px">ESTADÍSTICAS</h2>
<table>
    <tr style="font-weight: bold">
        <td>JESUITA CON MÁS VISITAS REALIZADAS</td>
        <td>NUMERO TOTAL DE VISITAS</td>
    </tr>
    <tr>
        <td><?php echo $jesuita?></td>
        <td><?php echo $nVisitas?></td>
    </tr>
</table>
<a href="main.html" id="volver">VOLVER</a>
</body>
</html>
