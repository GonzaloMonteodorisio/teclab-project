<?php
include $_SERVER['DOCUMENT_ROOT'] . '/MIPROYECTO/class/autoload.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $miproducto = new Productos();
        $miproducto->nombre = $_POST['nombre'];
        $miproducto->descripcion = $_POST['descripcion'];
        $miproducto->precio = $_POST['precio'];
        $miproducto->categoria = $_POST['categoria'];
        $miCategoria->guardar();
        
    } elseif (isset($_GET['add'])) {
        include $_SERVER['DOCUMENT_ROOT'] . '/MIPROYECTO/backend/views/productos.html';
        die();
    }

    $lista_pro = Productos::listar();

    include $_SERVER['DOCUMENT_ROOT'] . '/MIPROYECTO/backend/views/lista_productos.html';

} catch (Exception $e) {
    echo "Error: " . $e->getMessage(); 
}
?>