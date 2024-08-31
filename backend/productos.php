<?php
require_once '../class/autoload.php';

$productos = [
    new Producto(1, 'Laptop Dell', 'Laptop de alto rendimiento', 1500, 1),
    new Producto(2, 'Mouse Logitech', 'Mouse inalámbrico', 50, 2),
    // Agregar más productos según se necesite.
];

header('Content-Type: application/json');
echo json_encode($productos);
?>