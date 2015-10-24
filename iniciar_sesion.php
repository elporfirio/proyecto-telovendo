<?php

//Iniciamos trabajo con sesiones
session_start();

//Incluimos las clases
require_once("clases/class.php");


if($_POST != null){
	$datos = new consultaUsuario;
	$myusuario = $datos->comprobarUsuario($_POST["usuario"], $_POST["contrasena"]);
		
	if(sizeof($myusuario) != 0){
		foreach($myusuario as $indice => $campo){
			$_SESSION["id_usuario"] = $campo["idusuarios"];
			$_SESSION["nombre"] = $campo["nombre"];
			$_SESSION["email"] = $campo["email"];
		}
		print_r($_SESSION);
		header('Location: inicio.php');
	}
	else {
	?>
	
	<!doctype html>
		<html>
		<head>
		<meta charset="UTF-8">
		<title>Te lo vendo :: Usuario Incorrecto</title>
		<link href="css/estilos.css" rel="stylesheet" type="text/css">
		</head>
		
		<body>
		<div class="error">Datos incorrectos
			<br>
			<strong><a href='login.php'>regresar al inicio de sesión</a></strong>
		</div>
		</body>
		</html>
	<?php
	} //FIN DEL ELSE
} // FIN IF $_POST != null

?>