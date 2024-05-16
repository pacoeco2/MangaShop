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
    <link rel="stylesheet" type = "text/css" href="../css/styles_Principal.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>Libreria</title>
</head>
<body>
    <header>
    <div class="perfil-container">
    <a class = "perfil">
            <img src="<?php echo $imagensrc; ?>" alt="Foto de perfil" style="max-width: 150px; max-height: 150px; border-radius: 50%">  
        </a>
        <a class = "nombre"><?php echo $nombreUsu ?></a>
        <a href="Cerrar_sesion.php">Cerrar sesión</a>
    </div>
    </header>

    <?php 
    $que = mysqli_query($conexionU, "SELECT id,Nombre_Manga,Precio,Foto FROM inventario");

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

            // Muestra el manga
            echo '<div class="Libros">
                    <a class = "Nombre_Manga">'.$nom_man.'</a>
                    <a class = "portada" href="masinfo.php?id='.$row["id"].'">
                        <img src="'.$imagensrc_1.'" alt="Portada del Manga" style="max-width: 200px; max-height: 200px">
                    </a>
                    <a class = "Precio_Manga">$'.$pre_man.'</a>
                    <button class="CarritoP"><i class="bi bi-cart-plus"></i></button>
                  </div>';
        }
    }else{
        echo "Error en la consulta ". mysqli_error($conexionU);
        exit();
    }

    mysqli_close($conexionU);
?>
</body>

<footer>
        <div class="registro">
            <a href="../Inventario/Registrar_Mangas.php">¿Registrar un manga?</a>
        </div>
        <div class="info">
            <p>Para mas informacion contactar:</p>
            <a href="mailto:pacoeco23@hotmail.com"><i class="bi bi-envelope"></i></a><br>
        </div>
</footer>

</html>