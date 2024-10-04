<?php
include $_SERVER['DOCUMENT_ROOT'] . '/MIPROYECTO/class/autoload.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['id'])) {
            // Editar categoría
            $miCategoria = new Categorias($_POST['id']);
            $miCategoria->nombre = $_POST['nombre'];
            $miCategoria->guardar();
        } else {
            // Crear nueva categoría
            $miCategoria = new Categorias();
            $miCategoria->nombre = $_POST['nombre'];
            $miCategoria->guardar();
        }
        header('Location: http://localhost:8080/MIPROYECTO/backend/categorias.php');
    } elseif (isset($_GET['edit'])) {
        // Cargar categoría para editar
        $miCategoria = new Categorias($_GET['edit']);
        $categoria_id = $miCategoria->getId();
        $nombre_categoria = $miCategoria->nombre;
        include $_SERVER['DOCUMENT_ROOT'] . '/MIPROYECTO/backend/views/categorias.html';
        die();
    } elseif (isset($_GET['delete'])) {
        // Verificar si hay productos asociados a la categoría
        if (Productos::existeProductoConCategoria($_GET['delete'])) {
            // Si hay productos asociados, mostrar una alerta y no eliminar
            echo "<script>alert('No se puede eliminar la categoría porque está asociada a productos.'); window.location.href='http://localhost:8080/MIPROYECTO/backend/categorias.php';</script>";
        } else {
            // Eliminar categoría
            $miCategoria = new Categorias($_GET['delete']);
            $miCategoria->eliminar();
            header('Location: http://localhost:8080/MIPROYECTO/backend/categorias.php');
        }
    } elseif (isset($_GET['add'])) {
        include $_SERVER['DOCUMENT_ROOT'] . '/MIPROYECTO/backend/views/categorias.html';
        die();
    }
    
    $lista_ctg = Categorias::listar();
    
    include $_SERVER['DOCUMENT_ROOT'] . '/MIPROYECTO/backend/views/lista_categorias.html';
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>