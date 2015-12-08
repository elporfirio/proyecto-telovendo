<?php
session_start();


require_once('clases/Conexion.php');
require_once('clases/ControladorJuego.php');
require_once('clases/Juego.php');


if (isset($_POST)) {
    $juego = new Juego();

    $juego->usuario = $_SESSION["usuario"];
    $juego->nombre = $_POST["nombre"];
    $juego->consola = $_POST["consola"];
    $juego->genero = $_POST["genero"];
    $juego->descripcion = $_POST["descripcion"];
    $juego->portada = $_FILES["portada"];
    $juego->precio = $_POST["precio"];


    $conexion = new Conexion();

    $controladorJuego = new ControladorJuego();

    $resultado = $controladorJuego->registrarJuego($juego, $conexion);

}
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Te lo vendo :: Usuario Registrado</title>
<link href="css/estilos.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php

echo "<div class=\"". $controladorJuego->claseResultado ."\"> $controladorJuego->mensajeResultado
		<br>";

if ($resultado != false) {
    echo "<strong><a href='inicio.php'>< Regresar</a></strong>";
}

echo "</div>";

?>
</body>
</html>