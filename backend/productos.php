<?php
include $_SERVER['DOCUMENT_ROOT'] . '/MIPROYECTO/class/autoload.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    $categorias = Categorias::listar();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Editar o crear producto
        if (isset($_POST['id'])) {
            // Editar producto existente
            $miProducto = new Productos($_POST['id']);
        } else {
            // Crear nuevo producto
            $miProducto = new Productos();
        }

        $miProducto->nombre = $_POST['nombre'];
        $miProducto->descripcion = $_POST['descripcion'];
        $miProducto->precio = $_POST['precio'];
        $miProducto->categoria = $_POST['categoria'];

        // Manejo de la imagen
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $nombreImagen = basename($_FILES['imagen']['name']);
            $rutaImagen = $_SERVER['DOCUMENT_ROOT'] . '/MIPROYECTO/assets/uploads/' . $nombreImagen;

            // Mover el archivo subido a la carpeta de destino
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen)) {
                $miProducto->imagen = $nombreImagen;
            } else {
                throw new Exception("Error al subir la imagen.");
            }
        } else {
            // Si no se sube ninguna imagen nueva y es un producto existente
            if (!$miProducto->imagen) {
                $miProducto->imagen = 'default.png'; // Imagen por defecto si no hay imagen previa
            }
        }

        // Guardar el producto
        if ($miProducto->guardar()) {
            header('Location: http://localhost:8080/MIPROYECTO/backend/productos.php');
            exit;
        } else {
            echo "Error al guardar el producto.";
        }

    } elseif (isset($_GET['edit'])) {
        // Cargar producto para editar
        $miProducto = new Productos($_GET['edit']);
        
        if ($miProducto->getId()) {
            include $_SERVER['DOCUMENT_ROOT'] . '/MIPROYECTO/backend/views/productos.html';
        } else {
            echo "Producto no encontrado.";
        }
        exit;

    } elseif (isset($_GET['add'])) {
        // Agregar un nuevo producto
        include $_SERVER['DOCUMENT_ROOT'] . '/MIPROYECTO/backend/views/productos.html';
        exit;

    } elseif (isset($_GET['delete'])) {
        // Eliminar producto
        $miProducto = new Productos($_GET['delete']);
        if ($miProducto->eliminar()) {
            header('Location: http://localhost:8080/MIPROYECTO/backend/productos.php');
        } else {
            echo "Error al eliminar el producto.";
        }
        exit;
    }

    // Listar productos
    $lista_pro = Productos::listar();
    include $_SERVER['DOCUMENT_ROOT'] . '/MIPROYECTO/backend/views/lista_productos.html';

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
