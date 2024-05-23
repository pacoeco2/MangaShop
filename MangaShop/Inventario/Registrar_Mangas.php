<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresar Mangas a la Base de Datos</title>
    <link rel="stylesheet" href="../css/styles_RMangas.css">
</head>
<body>
    <div class="contenedor_all">
        <div class="contenedor_login_register">
                <form action="Guardado.php" method="POST" enctype="multipart/form-data">
                    <h2>Registro de Mangas</h2>
                    <input type="text" placeholder ="Nombre del Manga (y número)" REQUIRED name = "nombre">
                    <br>
                    <input type="file" name="foto" REQUIRED> <br>
                    <small>Portada del Manga (de preferencia .png)</small>
                    <br>
                    <input type="text" placeholder ="Descripción del manga (del volumen en cuestión)" name = "descripcion">
                    <br>
                    <input type="text" placeholder = "Precio (solo números, no símbolos)" REQUIRED name ="precio">
                    <button>Registrar</button>

                    <br><br><br>
                    <a href="../php/Principal.php">Regresar a la página principal</a>
                </form>
        </div>
    </div>
</body>
</html>