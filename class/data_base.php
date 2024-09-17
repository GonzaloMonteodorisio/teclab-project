<?php
/* @autor Gonzalo Monteodorisio */
echo "Archivo /class/data_base.php incluido correctamente.<br><br>";

// Intentar establecer conexión PDO a la base de datos
try {
    $conector = new PDO("mysql:dbname=MIPROYECTO;host=127.0.0.1", "root", "chalo1234");
    echo "Conexión exitosa";
    // Prueba con una consulta simple
    $consulta = $conector->query('SELECT * FROM categorias LIMIT 1');
    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
    print_r($resultado);
} catch (PDOException $ex) {
    echo "Fallo de conexión: " . $ex->getMessage();
}

// Clase base_datos para manejar operaciones de base de datos
class data_base {
    private $gbd; // Objeto de conexión PDO

    // Constructor para inicializar la conexión
    function __construct($driver, $base_datos, $host, $user, $pass) {
        try {
            // Crear la cadena de conexión
            $conexion = $driver . ":dbname=" . $base_datos . ";host=" . $host;

            // Inicializar la conexión PDO
            $this->gbd = new PDO($conexion, $user, $pass);
            $this->gbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Activar el manejo de errores excepcionales

            // Verificar la conexión
            if (!$this->gbd) {
                throw new Exception("No se ha podido realizar la conexión");
            }
        } catch (PDOException $ex) {
            echo "Fallo de conexión: " . $ex->getMessage();
        }
    }

    // Método para realizar consultas SELECT
    function select($tabla, $filtros = null, $arr_prepare = null, $orden = null, $limit = null) {
        try {
            $sql = "SELECT * FROM " . $tabla;

            if ($filtros != null) {
                $sql .= " WHERE " . $filtros;
            }

            if ($orden != null) {
                $sql .= " ORDER BY " . $orden;
            }

            if ($limit != null) {
                $sql .= " LIMIT " . $limit;
            }

            // Preparar la consulta
            $resource = $this->gbd->prepare($sql);
            $resource->execute($arr_prepare);

            // Verificar si la consulta fue exitosa
            if ($resource) {
                return $resource->fetchAll(PDO::FETCH_ASSOC);
            } else {
                throw new Exception("No se pudo realizar la consulta de selección");
            }
        } catch (PDOException $ex) {
            echo "Error: " . $ex->getMessage();
        }
    }
    
    // Método para realizar consultas DELETE
    function delete($tabla, $filtros = null, $arr_prepare = null) {
        try {
            $sql = "DELETE FROM " . $tabla . " WHERE " . $filtros;
            $resource = $this->gbd->prepare($sql);
            $resource->execute($arr_prepare);

            if ($resource) {
                return true;
            } else {
                throw new Exception("No se pudo realizar la consulta de eliminación");
            }
        } catch (PDOException $ex) {
            echo "Error: " . $ex->getMessage();
        }
    }
    
    // Método para realizar consultas INSERT
    function insert($tabla, $campos, $valores, $arr_prepare = null) {
        try {
            $sql = "INSERT INTO " . $tabla . " (" . $campos . ") VALUES (" . $valores . ")";
            $resource = $this->gbd->prepare($sql);
            $resource->execute($arr_prepare);

            if ($resource) {
                return $this->gbd->lastInsertId();
            } else {
                throw new Exception("No se pudo realizar la consulta de inserción");
            }
        } catch (PDOException $ex) {
            echo "Error: " . $ex->getMessage();
        }
    } 
    
    // Método para realizar consultas UPDATE
    function update($tabla, $campos, $filtros, $arr_prepare = null) {
        try {
            $sql = "UPDATE " . $tabla . " SET " . $campos . " WHERE " . $filtros;
            $resource = $this->gbd->prepare($sql);
            $resource->execute($arr_prepare);

            if ($resource) {
                return true;
            } else {
                throw new Exception("No se pudo realizar la consulta de actualización");
            }
        } catch (PDOException $ex) {
            echo "Error: " . $ex->getMessage();
        }
    }
}

?>
