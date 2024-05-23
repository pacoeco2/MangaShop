<?php
session_start();
include 'conexion_usuario.php';

$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $nombreManga = $data['Nombre_Manga'];
    $foto = base64_decode(explode(',', $data['Foto'])[1]);
    $precio = $data['Precio'];
    $id_usuario = $_SESSION['Usuario']; // Asumiendo que id del usuario se guarda en la sesión
    $cantidad = $data['Cantidad'];

    $query = "INSERT INTO carrito (Nombre_Manga, Foto, Precio, id_usuario, Cantidad) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexionU, $query);
    mysqli_stmt_bind_param($stmt, "ssdis", $nombreManga, $foto, $precio, $id_usuario, $cantidad);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(["status" => "success", "message" => "Producto agregado al carrito"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al agregar el producto al carrito"]);
    }

    mysqli_stmt_close($stmt);
} else {
    echo json_encode(["status" => "error", "message" => "Datos inválidos"]);
}

mysqli_close($conexionU);
?>
