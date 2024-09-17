<?php
/* @autor Gonzalo Monteodorisio */

class Productos {
    public $id;
    public $nombre;
    public $descripcion;
    public $precio;
    public $categoria;
    private $exist = false;

    function __construct($id = null) {
        $db = new data_base("mysql", "MIPROYECTO", "127.0.0.1", "root", "chalo1234");
        
        if ($id !== null) {
            $resp = $db->select("productos", "id=?", array($id));

            if (isset($resp[0]['id'])) {
                $this->id = $resp[0]['id'];
                $this->nombre = $resp[0]['nombre'];
                $this->descripcion = $resp[0]['descripcion'];
                $this->precio = $resp[0]['precio'];
                $this->categoria = $resp[0]['categoria_id'];
                $this->exist = true;
            }
        }

    }

    public function mostrar() {
        echo "<pre>";
        print_r($this);
        echo "</pre>";
    }

    public function guardar() {
        $db = new data_base("mysql", "MIPROYECTO", "127.0.0.1", "root", "chalo1234");
        if ($this->exist) {
            return $this->actualizar($db);
        } else {
            return $this->insertar($db);
        }
    }

    public function eliminar() {
        $db = new data_base("mysql", "MIPROYECTO", "127.0.0.1", "root", "chalo1234");
        return $db->delete("productos", "id=?", array($this->id));
    }
    
    private function insertar($db) {
        $resp = $db->insert("productos", "nombre, descripcion, precio, categoria_id", "?,?,?,?",
            array($this->nombre, $this->descripcion, $this->precio, $this->categoria));

        if ($resp) {
            $this->id = $resp;
            $this->exist = true;
            return true;
        } else {
            return false;
        }
    }

    private function actualizar($db) {
        return $db->update("productos", "nombre=?, descripcion=?, precio=?, categoria_id=?", "id=?",
            array($this->nombre, $this->descripcion, $this->precio, $this->categoria, $this->id));
    }

    static public function listar() {
        $db = new data_base("mysql", "MIPROYECTO", "127.0.0.1", "root", "chalo1234");
        return $db->select("productos");
    }
}

?>