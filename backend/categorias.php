<?php
require_once '../class/autoload.php';

$categorias = [
    new Categoria(1, 'Computadoras', 'Todo tipo de computadoras.'),
    new Categoria(2, 'Accesorios', 'Accesorios de computación.'),
    // Agregar más categorías según se necesite.
];

header('Content-Type: application/json');
echo json_encode($categorias);
?>