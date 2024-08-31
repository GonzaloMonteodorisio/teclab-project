<?php

class Producto {
    public $id;
    public $nombre;
    public $descripcion;
    public $precio;
    public $categoria_id;

    public function __construct($id, $nombre, $descripcion, $precio, $categoria_id) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->categoria_id = $categoria_id;
    }
}