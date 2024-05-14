<?php
    include 'conexion_usuario.php';

    // Verificar si se enviaron los datos del formulario
    if(isset($_POST['nombre'], $_POST['corre'], $_POST['usuari'], $_POST['contrasen'])){
        $nombre_completo = $_POST['nombre'];
        $correo = $_POST['corre'];
        $usuario = $_POST['usuari'];
        $contrasena = $_POST['contrasen'];

        // Verifica si se subió un archivo
        if(isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['tmp_name'] != ""){
            // Carga la imagen
            $imagen = imagecreatefromstring(file_get_contents($_FILES['foto_perfil']['tmp_name']));

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

        // Query para insertar el usuario en la base de datos
        $query = "INSERT INTO usuarios(Nombre, Correo, Usuario, Foto, Contraseña) 
                  VALUES('$nombre_completo','$correo','$usuario','$imagenSQL','$contrasena')";

        // Verificar que el correo o usuario no se repita
        $veri_usuario = mysqli_query($conexionU, "SELECT * FROM usuarios WHERE Usuario = '$usuario'");
        $veri_correo = mysqli_query($conexionU, "SELECT * FROM usuarios WHERE Correo = '$correo'");

        if(mysqli_num_rows($veri_correo) > 0){
            echo '<script>
                    alert("El correo ya está asociado a una cuenta. Intente de nuevo");
                    window.location = "../index.php";
                  </script>';
            exit();
        }

        if(mysqli_num_rows($veri_usuario) > 0){
            echo '<script>
                    alert("El usuario ya está asociado a una cuenta. Intente de nuevo");
                    window.location = "../index.php";
                  </script>';
            exit();
        }

        // Ejecutar la consulta de inserción
        $ejecutar = mysqli_query($conexionU, $query);

        if($ejecutar){
            echo '<script>
                    alert("Usuario registrado con éxito");
                    window.location = "../index.php";
                  </script>';
        }else{
            echo '<script>
                    alert("Usuario no registrado, intente de nuevo");
                  </script>';
        }
    }else{
        echo '<script>
                alert("Error: Datos del formulario no recibidos correctamente");
                window.location = "../index.php";
              </script>';
        exit();
    }

    mysqli_close($conexion);
?>
