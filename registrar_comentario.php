<?php
session_start();
require_once("clases/class.php");

//print_r($_POST);

if(isset($_POST)){
	$juego = $_POST["juego"];
	$comentarios = $_POST["comentarios"];
	$fecha = date("Y-m-d H:i:s");    
	
	
	$datos = new consultaComentario();
	$nuevo_comentario = $datos->registrarComentario($_SESSION["id_usuario"],$juego, $comentarios, $fecha);
	
	//var_dump($nuevo_comentario);
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

	if($nuevo_comentario){
		echo "<div class=\"success\">Gracias por su comentario
				<br>
				<strong><a href='javascript:history.back()'>Regresar a los detalles del juego</a></strong></div>";
	} // FIN $_POST no nulo

?>
</body>
</html>