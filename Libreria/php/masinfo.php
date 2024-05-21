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
    <link rel="stylesheet" type = "text/css" href="../css/styles_MI.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>Mas informacion</title>
    <style>
        .fade-in {
            opacity: 0;
            transition: opacity 0.5s;
        }
        .fade-in.visible {
            opacity: 1;
        }
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
        .menu-icon {
            cursor: pointer;
            margin-left: 75vw;
            height:10px;
        }
        .side-menu {
            width: 250px;
            height: 100%;
            background-color: #333;
            color: #fff;
            position: fixed;
            top: 0;
            right: -250px;
            transition: right 0.3s ease;
            padding: 20px;
            box-shadow: -2px 0 5px rgba(0,0,0,0.5);
            padding-top: 20px; 
        }
        .user-info {
            text-align: center;
            margin-bottom: 30px; 
        }
        .user-photo {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            margin-bottom: 20px;
            margin-top:50px;
        }
        .username {
            font-size: 18px;
            font-weight: bold;
        }
        .menu-options {
            list-style-type: none;
            padding: 0;
        }
        .menu-options li {
            margin: 20px 0; 
        }
        .menu-options a {
            color: #fff;
            text-decoration: none;
        }
        .menu-options a:hover {
            text-decoration: underline;
        }
        
        footer {
            background-color: #333;
            color: #fff;
            display: flex;
            text-align: center;
            bottom: 0;
            width: 100%;
            flex-direction: row-reverse;
            position: fixed;
            justify-content: center;
        }
    </style>
</head>
<body>
<header>
    <div class="perfil-container">
        <p class="menu-icon"><span class="glyphicon glyphicon-align-justify"></span></p>
        <div class="carrito-container">
            <i class="bi bi-cart" id="carrito-icon"></i>
            <div class="carrito-submenu" id="carrito-submenu">
                <div class="carrito-items" id="carrito-items"></div>
                <div class="carrito-total" id="carrito-total">Total: $0</div>
            </div>
        </div>
    </div>
</header>
<div class="side-menu">
    <div class="user-info">
        <img src="<?php echo $imagensrc; ?>" alt="Foto de usuario" class="user-photo">
        <p class="username"><?php echo $nombreUsu ?></p>
    </div>
    <ul class="menu-options">
        <li><a href="" id="change-photo">Cambiar foto</a></li>
        <li><a href="Cerrar_sesion.php">Cerrar sesión</a></li>
    </ul>
</div>
    <div class="Contenedor">
        <?php
        $searchTerm = '';
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
            $searchTerm = mysqli_real_escape_string($conexionU, $_POST['search']);
            $query = "SELECT id, Nombre_Manga, Descripcion, Precio, Foto FROM inventario WHERE Nombre_Manga LIKE '%$searchTerm%'";
        } else {
            $query = "SELECT id, Nombre_Manga, Descripcion, Precio, Foto FROM inventario";
        }
    
        $que = mysqli_query($conexionU,$query);
        if($que){
            while ($row=mysqli_fetch_assoc($que)) {
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
                echo "<img src=".$imagensrc_1." alt='Portada del Manga' class='Portada'>";
                echo "<div class='InfoD'>";
                echo "<h1 class='Titulo'>".$row["Nombre_Manga"]."</h1>";
                echo "<p class='Desc'>".$row["Descripcion"]."</p>";
                    echo "<div class='CompraI'>";
                        echo "<p class='Precio'>$".$row["Precio"]."</p>";
                            echo '<div class="Compra">';
                                echo '<div class="cantidad-selector">
                                        <button class="minus">-</button>
                                        <input type="number" class="cantidad" value="1" min="1">
                                        <button class="plus">+</button>
                                        </div>';
                                echo '<button class="CarritoP" 
                                        data-id="'.$row["id"].'" 
                                        data-nombre="'.$row["Nombre_Manga"].'" 
                                        data-precio="'.$row["Precio"].'" 
                                        data-imagen="'.$imagensrc_1.'">
                                    <i class="bi bi-cart-plus"></i>
                                    </button>';
                            echo "</div>";
                    echo "</div>";
                echo "</div>";
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
