<?php
// definicion de la clase CrudLugar
class CrudLugar {
    private $conexion; // Variable para almacenar la conexión a la base de datos
    // Constructor de la clase  se ejecuta al crear un objeto CrudLugar
    public function __construct($servername, $username, $password, $dbname) {
        // Establece una conexion con la base de datos utilizando los datos proporcionados
        $this->conexion = new mysqli($servername, $username, $password, $dbname);
        $this->conexion->set_charset('UTF8'); // Configura la codificacion de caracteres
        // Verifica si la conexion a la base de datos falla y muestra un mensaje de error
        if ($this->conexion->connect_error) {
            die("Error de conexión: ".$this->conexion->connect_error);
        }
    }
    // Método para agregar un lugar a la base de datos
    public function altaLugar($ip, $lugar, $descipcion) {
        $sql = "INSERT INTO lugar (ip, lugar, descripcion) VALUES ('".$ip."', '".$lugar."',$descipcion)";
        // $descricpion no lleva comillas ya que se le añaden a la propia variable dependiendo si tiene contenido o no
        try {
            if ($this->conexion->query($sql) === TRUE) {
                $mensaje = "Lugar creado correctamente";
            } else {
                $mensaje = "Error al crear Lugar: ".$this->conexion->error;
            }
        } catch (mysqli_sql_exception $e) {
            // Verifica si el error es debido a una ip duplicada y muestra un mensaje adecuado
            if ($e->getCode() === 1062) {
                $mensaje = "Error: El lugar asociado a esa IP ya existe en la base de datos.";
            } else {
                $mensaje = "Error: " . $e->getMessage();
            }
        }
        return $mensaje; // Devuelve un mensaje indicando el resultado de la operacion
    }
    // Método para buscar un lugar por su dirección IP
    public function buscarLugar($ip){
        $sql = "SELECT ip, lugar, descripcion FROM lugar WHERE ip = '".$ip."';";
        $result = $this->conexion->query($sql);

        if ($result) {
            if ($result->num_rows > 0) {
                return $result; // Si se encontraron resultados , devuelve los resultados.
            } else {
                $mensaje = "No se encontró un Lugar con la IP seleccionada.";
            }
        } else {
            $mensaje = "Error al buscar Lugar: ".$this->conexion->error;
        }
        return $mensaje; // Devuelve un mensaje indicando el resultado de la búsqueda
    }
    // Método para listar todos los lugares de la base de datos
    public function listarLugares(){
        $sql = "SELECT ip, lugar, descripcion FROM lugar order by lugar";
        $result = $this->conexion->query($sql);
        if ($result){
            if($result->num_rows > 0)
                return $result; // Si hay lugares , devuelve los resultados
            else
                $mensaje =  "No existen Lugares";
        }else{
            $mensaje = "Error al buscar Lugares: ".$this->conexion->error;
        }
        return $mensaje; // Devuelve un mensaje indicando el resultado de la operación
    }
    // Método para listar solo los nombres de los lugares
    public function nombreLugares(){
        $sql = "SELECT lugar FROM lugar order by lugar";
        $result = $this->conexion->query($sql);
        if ($result){
            if($result->num_rows > 0)
                return $result; // Si hay lugares, devuelve los resultados
            else
                $mensaje =  "No existen Lugares";
        }else{
            $mensaje = "Error al buscar Lugares: ".$this->conexion->error;
        }
        return $mensaje; // Devuelve un mensaje indicando el resultado de la operación
    }
    // Método para modificar la información de un lugar existente
    public function modificarLugar($ip, $lugar, $descripcion) {
        // Recalcar que para poder modificar correctamente el lugar hay que añadir borrado y modificación en cascada a la fk de la tabla visita
        $sql = "UPDATE lugar SET lugar = '".$lugar."', descripcion = '".$descripcion."' WHERE ip = '".$ip."';";

        if ($this->conexion->query($sql) === TRUE) {
            $mensaje = "Lugar modificado correctamente.";
        } else {
            echo $this->conexion->error;
            echo $this->conexion->errno;
        }
        return $mensaje; // Devuelve un mensaje indicando el resultado de la operación
    }
    // Método para eliminar un lugar de la base de datos
    public function borrarLugar($ip) {
        // Recalcar que para poder modificar correctamente el lugar hay que añadir borrado y modificación en cascada a la fk de la tabla visita
        $sql = "DELETE FROM lugar WHERE ip = '".$ip."';";

        if ($this->conexion->query($sql) === TRUE) {
            $mensaje =  "Lugar borrado correctamente.";
        } else {
            echo $this->conexion->error;
            echo $this->conexion->errno;
        }
        return $mensaje; // Devuelve un mensaje indicando el resultado de la operación
    }
    // Destructor de la clase, se encarga de cerrar la conexión a la base de datos
    public function __destruct() {
        $this->conexion->close();
    }
}


