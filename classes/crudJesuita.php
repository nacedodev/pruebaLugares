<?php
class CrudJesuita {
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

    // Método para agregar un nuevo Jesuita a la base de datos
    public function altaJesuita($idJesuita, $nombre, $firma) {
        $sql = "INSERT INTO jesuita (idJesuita, nombre, firma) VALUES ('" . $idJesuita . "','" . $nombre . "','" . $firma . "')";

        try {
            // Ejecutamos la consulta SQL y manejamos posibles errores
            if ($this->conexion->query($sql) === TRUE) {
                $mensaje = "Jesuita creado correctamente.";
            } else {
                $mensaje = "Error al crear Jesuita: " . $this->conexion->error;
            }
        } catch (mysqli_sql_exception $e) {
            // Verificamos si el error es debido a una duplicación de IP
            if ($e->getCode() === 1062) {
                $mensaje = "Error: El Jesuita asociado a esa IP ya existe en la base de datos.";
            } else {
                $mensaje = "Error: " . $e->getMessage();
            }
        }
        return $mensaje; // Devolvemos el mensaje
    }

    // Método para listar los nombres de todos los Jesuitas
    public function listarJesuitas() {
        $sql = "SELECT nombre FROM jesuita ORDER BY nombre;";
        $result = $this->conexion->query($sql);
        if ($result) {
            if ($result->num_rows > 0) {
                return $result;
            } else {
                $mensaje = "No existen Jesuitas";
            }
        } else {
            $mensaje = "Error al buscar Jesuitas: " . $this->conexion->error;
        }
        return $mensaje; // Devolvemos el mensaje
    }

    // Método para verificar la firma de un Jesuita
    public function verificarJesuita($nombre, $firma) {
        $sql = "SELECT firma FROM jesuita WHERE nombre = '" . $nombre . "';";
        $result = $this->conexion->query($sql);

        if ($result) {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $firmaJesuita = $row['firma'];

                if ($firma == $firmaJesuita) {
                    return true; // La firma coincide
                } else {
                    return false; // La firma no coincide
                }
            } else {
                $mensaje = "No se encontró al Jesuita con el nombre proporcionado.";
            }
        } else {
            $mensaje = "Error al verificar al Jesuita: " . $this->conexion->error;
        }
        return $mensaje; // Devolvemos el mensaje
    }

    // Método para listar todas las firmas de los Jesuitas
    public function listarFirmas() {
        $sql = "SELECT firma FROM jesuita ORDER BY firma";
        $result = $this->conexion->query($sql);
        if ($result) {
            if ($result->num_rows > 0) {
                return $result;
            } else {
                $mensaje = "No existen Jesuitas";
            }
        } else {
            $mensaje = "Error al buscar Jesuitas: " . $this->conexion->error;
        }
        return $mensaje; // Devolvemos el mensaje
    }

    // Método para buscar un Jesuita por su ID
    public function buscarJesuita($idJesuita) {
        // Recalcar que para poder eliminar correctamente el jesuita hay que añadir borrado y modificación en cascada a la fk de la tabla visita
        $sql = "SELECT idJesuita, nombre, firma FROM jesuita WHERE idJesuita = '" . $idJesuita . "'";
        $result = $this->conexion->query($sql);

        if ($result) {
            if ($result->num_rows > 0) {
                return $result;
            } else {
                $mensaje = "No se encontró un Jesuita con el ID proporcionado.";
            }
        } else {
            $mensaje = "Error al buscar Jesuita: " . $this->conexion->error;
        }
        return $mensaje; // Devolvemos el mensaje
    }

    // Método para modificar los datos de un Jesuita
    public function modificarJesuita($idJesuita, $nombre, $firma) {
        // Recalcar que para poder modificar correctamente el jesuita hay que añadir borrado y modificación en cascada a la fk de la tabla visita
        $sql = "UPDATE jesuita SET nombre = '" . $nombre . "', firma = '" . $firma . "' WHERE idJesuita = '" . $idJesuita . "'";

        if ($this->conexion->query($sql) === TRUE) {
            $mensaje = "Jesuita modificado correctamente.";
        } else {
            $mensaje = "Error al modificar Jesuita: " . $this->conexion->error;
        }
        return $mensaje; // Devolvemos el mensaje
    }

    // Método para borrar un Jesuita por su ID
    public function borrarJesuita($idJesuita) {
        $sql = "DELETE FROM jesuita WHERE idJesuita = '" . $idJesuita . "'";

        if ($this->conexion->query($sql) === TRUE) {
            $mensaje = "Jesuita borrado correctamente.";
        } else {
            $mensaje = "Error al borrar Jesuita: " . $this->conexion->error;
        }
        return $mensaje; // Devolvemos el mensaje
    }

    // Destructor que cierra la conexión a la base de datos al finalizar
    public function __destruct() {
        $this->conexion->close();
    }
}