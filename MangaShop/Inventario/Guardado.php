<?php
include 'conexion_inv.php';

if(isset($_POST['nombre'], $_FILES['foto'], $_POST['precio']) && $_POST['nombre'] != "" && file_exists($_FILES['foto']['tmp_name']) && $_POST['precio'] != ""){
    $nombre = $_POST['nombre'];
    $foto = addslashes(file_get_contents($_FILES['foto']['tmp_name']));
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];

    if(isset($_FILES['foto']) && $_FILES['foto']['tmp_name'] != ""){
        // Carga la imagen
        $imagen = imagecreatefromstring(file_get_contents($_FILES['foto']['tmp_name']));

        // Obtiene las dimensiones originales de la imagen
        $anchoOriginal = imagesx($imagen);
        $altoOriginal = imagesy($imagen);

        // Define las dimensiones máximas
        $anchoMaximo = 500;
        $altoMaximo = 500;

        // Calcula las nuevas dimensiones manteniendo la proporción
        if($anchoOriginal > $altoOriginal){
            $anchoNuevo = $anchoMaximo;
            $altoNuevo = $altoOriginal * ($anchoMaximo / $anchoOriginal);
        }else{
            $altoNuevo = $altoMaximo;
            $anchoNuevo = $anchoOriginal * ($altoMaximo / $altoOriginal);
        }

        // Crea una nueva imagen con las dimensiones nuevas
        $imagenNueva = imagecreatetruecolor($anchoNuevo, $altoNuevo);

        // Redimensiona la imagen original y la copia en la imagen nueva
        imagecopyresampled($imagenNueva, $imagen, 0, 0, 0, 0, $anchoNuevo, $altoNuevo, $anchoOriginal, $altoOriginal);

        // Convierte la imagen nueva a una cadena de bytes
        ob_start();
        imagejpeg($imagenNueva);
        $imagenBytes = ob_get_clean();

        // Codifica la cadena de bytes para su uso en SQL
        $imagenSQL = addslashes($imagenBytes);
    }else{
        // Maneja el caso en que no se subió un archivo
        $imagenSQL = NULL;
    }
    $query ="INSERT INTO inventario(Nombre_Manga, Foto, Descripcion, Precio)
             VALUES ('$nombre', '$imagenSQL', '$descripcion', '$precio')";

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
