<?php
/* @autor Gonzalo Monteodorisio */
echo "Archivo /class/categorias.php incluido correctamente.<br><br>";

class Categorias {
    protected $id;
    public $nombre;
    private $exist;

    function __construct($id = null) {
        if ($id != null) {
            $db = new data_base("mysql", "mydatabase", "127.0.0.1", "root", "chalo1234");
            $resp = $db->select("categorias", "id=?", array($id));

            if (isset($resp[0]['id'])) {
                $this->id = $resp[0]['id'];
                $this->nombre = $resp[0]['nombre'];
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
        if ($this->exist) {
            return $this->actualizar();
        } else {
            return $this->insertar();
        }
    }

    public function eliminar() {
        $db = new data_base("mysql", "MIPROYECTO", "127.0.0.1", "root", "chalo1234");
        return $db->delete("categorias", "id = ?", array($this->id));
    }
    
    private function insertar() {
        $db = new data_base("mysql", "MIPROYECTO", "127.0.0.1", "root", "chalo1234");
        $resp = $db->insert("categorias", "nombre", "?", array($this->nombre));

        if ($resp) {
            $this->id = $resp;
            $this->exist = true;
            return true;
        } else {
            return false;
        }
    }

    private function actualizar() {
        $db = new data_base("mysql", "MIPROYECTO", "127.0.0.1", "root", "chalo1234");
        return $db->update("categorias", "nombre=?", "id=?", array($this->nombre, $this->id));
    }

    static public function listar() {
        $db = new data_base("mysql", "MIPROYECTO", "127.0.0.1", "root", "chalo1234");
        return $db->select("categorias");
    }
}

?>