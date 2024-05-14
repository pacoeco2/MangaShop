<?php
include 'conexion_inv.php';

if(isset($_POST['nombre'], $_FILES['foto'], $_POST['precio']) && $_POST['nombre'] != "" && file_exists($_FILES['foto']['tmp_name']) && $_POST['precio'] != ""){
    $nombre = $_POST['nombre'];
    $foto = addslashes(file_get_contents($_FILES['foto']['tmp_name']));
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];

    $query ="INSERT INTO inventario(Nombre_Manga, Foto, Descripcion, Precio)
             VALUES ('$nombre', '$foto', '$descripcion', '$precio')";

    $veri_manga = mysqli_query($conexionU, "SELECT * FROM inventario WHERE Nombre_Manga = '$nombre'");

    if(mysqli_num_rows($veri_manga) > 0){
        echo '<script>
                alert("El manga introducido ya existe en la Base de Datos. Intente con otro");
                window.location = "index.php";
              </script>';
        exit();
    }

    $exe = mysqli_query($conexionU, $query);

    if($exe){
        echo '<script>
              alert("Manga registrado con éxito");
              window.location = "Registrar_Mangas.php";
              </script>';
    }else{
        echo '<script>
              alert("Manga no registrado, intente de nuevo");
              window.location = "Registrar_Mangas.php";
              </script>';
    }
}else{
    echo '<script>
            alert("Error: Datos del formulario no recibidos correctamente");
            window.location = "Registrar_Mangas.php";
          </script>';
    exit();
}

mysqli_close($conexionU);
?>
