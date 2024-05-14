<?php
$bd = new mysqli("localhost","root","","libreria");
$id=$_GET["id"];
$query=mysqli_query($bd,"SELECT * from inventario WHERE id=$id");
while ($datos=mysqli_fetch_array($query)) {
    echo "<h1>".$datos["Nombre_Manga"]."</h1>";
    echo "<p>".$datos["Descripcion"]."</p>";
    
    // Crea $imagensrc_1 a partir de los datos de la imagen de la base de datos
    $portada = $datos['Foto'];
    $tipoImagen1 = "image/jpeg";
    $imagenbase64_1 = base64_encode($portada);
    $imagensrc_1 = "data:$tipoImagen1;base64,$imagenbase64_1";
    
    echo '<img src="'.$imagensrc_1.'" alt="Portada del Manga" style="max-width: 200px; max-height: 200px">';
    echo "<p>$".$datos["Precio"]."</p>";
}
?>