<?php
    session_start();
    if(isset($_SESSION['usuario'])){
        header("location: php/Principal.php");
        exit();
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles_index.css">
    <title>Login/Registro</title>
</head>
<body>
    <!--Div para mentener todo-->
     <div class="contenedor_all">
        <!--Div para las cajitas con información que aparecen atrás -->
        <div class="caja_back">
            <div class="caja_login">
                <h3>¿Ya tienes cuenta?</h3>
                <p>Inicia sesión para entrar en la página</p>
                <button id = "ini_ses">Iniciar sesión</button>
            </div>
            <div class="caja_regis">
                <h3>¿Aún no tienes cuenta?</h3>
                <p>Regístrate para iniciar sesión</p>
                <button id = "regi_usu">Registrarse</button>
            </div>
        </div>
        <!--Div para las cajas de enfrente que van a interactuar con el usuario-->
        <div class="contenedor_login_register">
            <form action="php/Login.php" method = "POST" class="form_login">
                <h2>Iniciar sesión</h2>
                 <input type="text" placeholder="Correo electrónico" REQUIRED name = "corr">
                 <input type="password" placeholder="Contraseña" REQUIRED name = "contra">
                 <button>Entrar</button>
            </form>

            <form action="php/Registro.php" method = "POST" class="form_regis" enctype = "multipart/form-data">
                <h2>Registrarse</h2>
                <input type="text" placeholder="Nombre Completo" name="nombre">
                <input type="text" placeholder="Correo electrónico" REQUIRED name = "corre">
                <input type="text" placeholder="Usuario" REQUIRED name="usuari">
                <input type="file" name = "foto_perfil">
                <small> Foto de perfil (Se admiten JPG, PNG)</small>
                <input type="password" placeholder="Contraseña" REQUIRED name="contrasen">
                <button>Registrarse</button>
            </form>

        </div>
     </div>
     <script src="js/script.js"></script>
</body>
</html>