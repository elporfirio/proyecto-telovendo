<?php
session_start();
//print_r($_SESSION);

require_once("clases/class.php");

if(isset($_POST) and $_POST != null){
	$nombre = $_POST["nombre_juego"];
	$consola = $_POST["consola_juego"];
	$genero = $_POST["genero_juego"];
	$descripcion = $_POST["descripcion_juego"];
	$portada = $_FILES["portada_juego"];
	$precio = $_POST["precio_juego"];
	
	$datos = new consultaJuego;
	$nuevo_juego = $datos->registrarJuego($_SESSION["id_usuario"],$nombre, $consola, $genero, $descripcion, $portada, $precio);
	
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

	if($nuevo_juego)
		echo "<div class=\"success\">Nuevo juego registrado
				<br>
				<strong><a href='inicio.php'>Regresar al inicio</a></strong></div>";
	} // FIN $_POST no nulo

?>
</body>
</html>