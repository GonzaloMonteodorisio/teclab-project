<?php
/* @autor Gonzalo Monteodorisio */

try {
    $conector = new PDO("mysql:dbname=MIPROYECTO;host=127.0.0.1", "root", "chalo1234");
} catch (PDOException $ex) {
    echo "Fallo de conexión: " . $ex->getMessage();
}

class data_base {
    private $gbd;

    function __construct($driver, $base_datos, $host, $user, $pass) {
        try {
            $conexion = $driver . ":dbname=" . $base_datos . ";host=" . $host;

            $this->gbd = new PDO($conexion, $user, $pass);
            $this->gbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if (!$this->gbd) {
                throw new Exception("No se ha podido realizar la conexión");
            }
        } catch (PDOException $ex) {
            echo "Fallo de conexión: " . $ex->getMessage();
        }
    }

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

            $resource = $this->gbd->prepare($sql);
            $resource->execute($arr_prepare);

            if ($resource) {
                return $resource->fetchAll(PDO::FETCH_ASSOC);
            } else {
                throw new Exception("No se pudo realizar la consulta de selección");
            }
        } catch (PDOException $ex) {
            echo "Error: " . $ex->getMessage();
        }
    }
    
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
