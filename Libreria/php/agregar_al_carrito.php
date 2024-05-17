<?php
session_start();

$id = $_GET['id'];

// Conéctate a la base de datos y obtén los detalles del manga
$conexionU = new mysqli('localhost', 'root', '', 'libreria');
$query = mysqli_query($conexionU, "SELECT Nombre_Manga, Precio FROM inventario WHERE id = '$id'");

if ($query) {
    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
        $nombre = $row['Nombre_Manga'];
        $precio = '$'. $row['Precio'];

        if (!isset($_SESSION['carrito'][$id])) {
            $_SESSION['carrito'][$id] = array(
                'nombre' => $nombre,
                'precio' => $precio,
                'cantidad' => 0
            );
        }

        $_SESSION['carrito'][$id]['cantidad']++;

        header('Content-Type: application/json');
        echo json_encode(array('carrito' => array_values($_SESSION['carrito'])));
    } else {
        echo "Error: Manga no encontrado en la base de datos";
        exit();
    }
} else {
    echo "Error en la consulta " . mysqli_error($conexionU);
    exit();
}
?>