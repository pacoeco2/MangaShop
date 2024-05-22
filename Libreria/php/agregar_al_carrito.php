<?php
session_start();

// Verifica si la sesión del carrito está iniciada
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
}

// Recibe los datos del producto enviado por AJAX
$id = $_POST['id'];
$nombre = $_POST['nombre'];
$precio = $_POST['precio'];
$imagen = $_POST['imagen'];

// Agrega el producto al arreglo del carrito
$_SESSION['carrito'][] = array(
    'id' => $id,
    'nombre' => $nombre,
    'precio' => $precio,
    'imagen' => $imagen,
    'cantidad' => 1 // Puedes establecer una cantidad predeterminada si lo deseas
);

// Responde con un mensaje indicando que el producto fue agregado al carrito
echo "Producto agregado al carrito correctamente";
?>