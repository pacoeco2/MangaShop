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

if (!isset($_SESSION['carrito'])){
    $_SESSION['carrito'] = array();
}
$correo = $_SESSION['Usuario'];
$query = mysqli_query($conexionU,"SELECT Usuario, Foto FROM usuarios where correo = '$correo'" );

if($query){
    if(mysqli_num_rows($query)>0){
        $row = mysqli_fetch_assoc($query);
        $nombreUsu = $row['Usuario'];
        $foto = $row['Foto'];

        if($foto){
            $tipoImagen = "image/jpeg";
            $imagenbase64 = base64_encode($foto);
            $imagensrc = "data:$tipoImagen;base64,$imagenbase64";
        }else{
            $imagensrc = "ruta/a/imagen/por/defecto.jpg"; // Puedes proporcionar una imagen por defecto
        }
    }else{
        echo "Error: Usuario no encontrado en la base de datos";
        exit();
    }
}else{
    echo "Error en la consulta ". mysqli_error($conexionU);
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/styles_Principal.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>Libreria</title>
    <style>
        .fade-in {
            opacity: 0;
            transition: opacity 0.5s;
        }
        .fade-in.visible {
            opacity: 1;
        }
        /* Estilos adicionales para el carrito */
        .carrito-container {
            position: relative;
        }
        .carrito-submenu {
            display: none;
            position: absolute;
            top: 40px;
            right: 0;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 300px;
            max-height: 400px;
            overflow-y: auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .carrito-submenu.visible {
            display: block;
        }
        .carrito-item {
            display: flex;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .carrito-item img {
            max-width: 50px;
            max-height: 50px;
            margin-right: 10px;
        }
        .carrito-item-details {
            flex-grow: 1;
        }
        .carrito-item-details p {
            margin: 0;
        }
        .carrito-total {
            padding: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<header>
    <div class="perfil-container">
        <div>
            <form method="POST" action="">
                <input type="text" name="search" class="buscador" placeholder="Buscar manga...">
                <button type="submit">Buscar</button>
            </form>
        </div>
        <a class="perfil">
            <img src="<?php echo $imagensrc; ?>" alt="Foto de perfil" style="max-width: 150px; max-height: 150px; border-radius: 50%">
        </a>
        <a class="nombre"><?php echo $nombreUsu ?></a>
        <a href="Cerrar_sesion.php">Cerrar sesión</a>
        <div class="carrito-container">
            <i class="bi bi-cart" id="carrito-icon"></i>
            <div class="carrito-submenu" id="carrito-submenu">
                <div class="carrito-items" id="carrito-items"></div>
                <div class="carrito-total" id="carrito-total">Total: $0</div>
            </div>
        </div>
    </div>
</header>
<div class="lista">
<?php 
    $searchTerm = '';
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
        $searchTerm = mysqli_real_escape_string($conexionU, $_POST['search']);
        $query = "SELECT id, Nombre_Manga, Precio, Foto FROM inventario WHERE Nombre_Manga LIKE '%$searchTerm%'";
    } else {
        $query = "SELECT id, Nombre_Manga, Precio, Foto FROM inventario";
    }

    $que = mysqli_query($conexionU,$query);

    if($que){
        while($row = mysqli_fetch_assoc($que)){
            $nom_man = $row['Nombre_Manga'];
            $pre_man = $row['Precio'];
            $portada = $row['Foto'];

            if($portada){
                $tipoImagen1 = "image/jpeg";
                $imagenbase64_1 = base64_encode($portada);
                $imagensrc_1 = "data:$tipoImagen1;base64,$imagenbase64_1";
            }else{
                $imagensrc_1 = "ruta/a/imagen/por/defecto.jpg";
            }
        
            echo '<div class="Libros fade-in">
                    <a class="Nombre_Manga">'.$nom_man.'</a>
                    <a class="portada" href="masinfo.php?id='.$row["id"].'">
                        <img src="'.$imagensrc_1.'" alt="Portada del Manga" style="max-width: 200px; max-height: 200px">
                    </a>
                    <a class="Precio_Manga">$'.$pre_man.'</a>
                    <div class="cantidad-selector">
                        <button class="minus">-</button>
                        <input type="number" class="cantidad" value="1" min="1">
                        <button class="plus">+</button>
                    </div>
                    <button class="CarritoP" 
                            data-id="'.$row["id"].'" 
                            data-nombre="'.$nom_man.'" 
                            data-precio="'.$pre_man.'" 
                            data-imagen="'.$imagensrc_1.'">
                        <i class="bi bi-cart-plus"></i>
                    </button>
                </div>';
        }
    }else{
        echo "Error en la consulta ". mysqli_error($conexionU);
        exit();
    }

    mysqli_close($conexionU);
    ?>
</div>
<script src="../js/Principal.js"></script>
<footer>
    <div class="registro">
        <a href="../Inventario/Registrar_Mangas.php">¿Registrar un manga?</a>
    </div>
    <div class="info">
        <p>Para mas informacion contactar:</p>
        <a href="mailto:pacoeco23@hotmail.com"><i class="bi bi-envelope"></i></a><br>
    </div>
</footer>
</body>
</html>
