<?php
class Visita {
    private $conexion;

    // Constructor que establece la conexión a la base de datos
    public function __construct($servername, $username, $password, $dbname) {
        $this->conexion = new mysqli($servername, $username, $password, $dbname);
        $this->conexion->set_charset('UTF8');

        // Comprobamos si la conexión tuvo éxito
        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }

    // Método para registrar una visita
    public function hacerVisita($nombre, $lugar, $firma) {
        // Buscamos el ID del Jesuita con el nombre y firma proporcionados
        $sql = "SELECT idJesuita FROM jesuita WHERE nombre = '" . $nombre . "' AND firma = '" . $firma . "'";
        $result = $this->conexion->query($sql);

        if ($result) {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $idJesuita = $row['idJesuita'];

                // Buscamos la IP correspondiente al lugar proporcionado
                $sql = "SELECT ip FROM lugar WHERE lugar = '" . $lugar . "'";
                $result = $this->conexion->query($sql);

                if ($result) {
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $ip = $row['ip'];

                        // Insertamos la visita en la tabla visitas
                        $sql = "INSERT INTO visita (idJesuita, ip, fechaHora) VALUES ('" . $idJesuita . "','" . $ip . "', now())";
                        $result = $this->conexion->query($sql);

                        if ($result) {
                            $mensaje = "Visita registrada exitosamente.";
                        } else {
                            $mensaje = "Error al registrar la visita: " . $this->conexion->error;
                        }
                    } else {
                        $mensaje = "No se encontró la IP del lugar.";
                    }
                } else {
                    $mensaje = "Error al obtener la IP del lugar: " . $this->conexion->error;
                }
            } else {
                $mensaje = "No se encontró al Jesuita con el nombre y firma proporcionados.";
            }
        } else {
            $mensaje = "Error al obtener el idJesuita: " . $this->conexion->error;
        }
        return $mensaje;
    }

    // Método para listar las últimas 5 visitas registradas
    public function listarVisitas() {
        $sql = "SELECT v.idVisita, j.nombre, v.fechaHora, l.lugar
                FROM visita v
                INNER JOIN jesuita j ON v.idJesuita = j.idJesuita
                INNER JOIN lugar l ON v.ip = l.ip
                ORDER BY v.fechaHora DESC
                LIMIT 5;";

        $result = $this->conexion->query($sql);
        if ($result) {
            if ($result->num_rows > 0) {
                return $result;
            } else {
                $mensaje = "No existen Visitas";
            }
        } else {
            $mensaje = "Error al buscar Visitas: " . $this->conexion->error;
        }
        return $mensaje;
    }

    public function maxVisitasJesuita(){
        $sql = "SELECT j.nombre , COUNT(*) AS total_visitas
                FROM visita v INNER JOIN jesuita j ON v.idJesuita = j.idJesuita
                GROUP BY v.idJesuita , j.nombre -- GROUP BY se utiliza para agrupar las filas de la tabla visita por los valores en las columnas idJesuita y nombre de la tabla jesuita.
                ORDER BY total_visitas DESC
                LIMIT 1;"; // Permitimos que únicamente nos devuelva un solo valore en orden descendente
        $result = $this->conexion->query($sql);
        if($result) {
            if ($result->num_rows > 0) {
                return $result;
            } else {
                $mensaje = "No existen visitas";
            }
        } else {
            $mensaje = "Error al buscar Visitas: ".$this->conexion->error;
        }

        return $mensaje;
    }

    public function maxVisitasLugar(){
        $sql = "SELECT l.lugar , COUNT(*) AS total_visitas
                FROM visita v INNER JOIN lugar l ON v.ip = l.ip 
                GROUP BY v.ip , l.lugar -- GROUP BY se utiliza para agrupar las filas de la tabla visita por los valores en las columnas idJesuita y nombre de la tabla jesuita.
                ORDER BY total_visitas DESC -- Ordenamos de manera descendente
                LIMIT 1; -- Permitimos que únicamente nos devuelva un solo valore en orden descendente
               ";
        $result = $this->conexion->query($sql);
        if($result) {
            if ($result->num_rows > 0) {
                return $result;
            } else {
                $mensaje = "No existen visitas";
            }
        } else {
            $mensaje = "Error al buscar Visitas: ".$this->conexion->error;
        }

        return $mensaje;
    }

    // Destructor que cierra la conexión a la base de datos al finalizar
    public function __destruct() {
        $this->conexion->close();
    }
}
