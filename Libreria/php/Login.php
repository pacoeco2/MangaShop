<?php
    session_start();

    include 'conexion_usuario.php';
    $correo = $_POST['corr'];
    $contras = $_POST['contra'];

    $validar_login = mysqli_query($conexionU, "SELECT * FROM usuarios WHERE Correo = '$correo' and Contraseña = '$contras'");

    if(mysqli_num_rows($validar_login) > 0){
        $_SESSION['Usuario'] = $correo;
        header("location: Principal.php");
        exit();
    }else{
        echo '
        <script>
            alert("Usuario o contraseña incorrectos o no existen");
            window.location = "../index.php";
        </script>';
        exit();
    }

?>