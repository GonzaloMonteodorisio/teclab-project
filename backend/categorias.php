<?php
include $_SERVER['DOCUMENT_ROOT'] . '/MIPROYECTO/class/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $miCategoria = new Categorias();
    $miCategoria->nombre = $_POST['nombre'];
    $miCategoria->guardar();
} elseif (isset($_GET['add'])) {
    include $_SERVER['DOCUMENT_ROOT'] . '/MIPROYECTO/backend/views/categorias.html';
    die();
}

$lista_ctg = Categorias::listar();

include $_SERVER['DOCUMENT_ROOT'] . '/MIPROYECTO/backend/views/lista_categorias.html';
?>