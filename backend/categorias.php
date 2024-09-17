<?php
echo "Archivo /backend/categorias.php incluido correctamente.<br><br>";
include $_SERVER['DOCUMENT_ROOT'] . '/MIPROYECTO/class/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo 'POST recibido';
    $miCategoria = new Categorias();
    $miCategoria->nombre = $_POST['nombre'];
    if ($miCategoria->guardar()) {
        echo "Categoría guardada exitosamente.";
    } else {
        echo "Error al guardar la categoría.";
    }
} elseif (isset($_GET['add'])) {
    include $_SERVER['DOCUMENT_ROOT'] . '/MIPROYECTO/backend/views/categorias.html';
    die();
} else {
    echo 'Ni GET ni POST';
}

$lista_ctg = Categorias::listar();
echo "<pre>";
print_r($lista_ctg);
echo "</pre>";
include $_SERVER['DOCUMENT_ROOT'] . '/MIPROYECTO/backend/views/lista_categorias.html';
?>