<?php
session_start();
include 'conexion_usuario.php';

if (!isset($_SESSION['Usuario'])) {
    echo '
    <script>
        alert("Por favor, inicia sesión");
        window.location = "../index.php";
    </script>';
    session_destroy();
    exit();
}

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
}

$correo = $_SESSION['Usuario'];
$query = mysqli_query($conexionU, "SELECT Usuario, Foto FROM usuarios WHERE correo = '$correo'");

if ($query) {
    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
        $nombreUsu = $row['Usuario'];
        $foto = $row['Foto'];

        if ($foto) {
            $tipoImagen = "image/jpeg";
            $imagenbase64 = base64_encode($foto);
            $imagensrc = "data:$tipoImagen;base64,$imagenbase64";
        } else {
            $imagensrc = "ruta/a/imagen/por/defecto.jpg";
        }
    } else {
        echo "Error: Usuario no encontrado en la base de datos";
        exit();
    }
} else {
    echo "Error en la consulta " . mysqli_error($conexionU);
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <title>Carrito de Compras</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .carrito-container {
            width: 80%;
            margin: auto;
            margin-top: 50px;
        }
        .carrito-item {
            display: flex;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }
        .carrito-item img {
            max-width: 100px;
            margin-right: 20px;
        }
        .carrito-item-details {
            flex-grow: 1;
        }
        .carrito-item-details p {
            margin: 5px 0;
        }
        .carrito-total {
            text-align: right;
            font-size: 20px;
            font-weight: bold;
            margin-top: 20px;
        }
        .header {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="header">
    <img src="<?php echo $imagensrc; ?>" alt="Foto de perfil" style="max-width: 150px; max-height: 150px; border-radius: 50%">
    <h2><?php echo $nombreUsu; ?></h2>
    <a href="Cerrar_sesion.php">Cerrar sesión</a>
</div>

<div class="carrito-container">
    <h3>Carrito de Compras</h3>
    <?php
    $total = 0;
    if (!empty($_SESSION['carrito'])) {
        foreach ($_SESSION['carrito'] as $producto) {
            echo '<div class="carrito-items">';
            echo '<img src="' . $producto['imagen'] . '" alt="Imagen del producto">';
            echo '<div class="carrito-items-details">';
            echo '<p><strong>' . $producto['nombre'] . '</strong></p>';
            echo '<p>Precio: $' . $producto['precio'] . '</p>';
            echo '<p>Cantidad: ' . $producto['cantidad'] . '</p>';
            echo '</div>';
            echo '</div>';
            $total += $producto['precio'] * $producto['cantidad'];
        }
        echo '<div class="carrito-total">Total: $' . $total . '</div>';
    } else {
        echo '<p>Tu carrito está vacío.</p>';
    }
    ?>
</div>
</body>
</html>
