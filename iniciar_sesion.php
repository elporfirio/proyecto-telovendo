<?php

//Iniciamos trabajo con sesiones
session_start();

//Incluimos las clases
require_once('clases/Usuario.php');
require_once('clases/Conexion.php');
require_once('clases/ControladorUsuario.php');


if(isset($_POST)){

    $usuario = new Usuario();

    $usuario->setContrasena($_POST["contrasena"]);
    $usuario->usuario = $_POST["usuario"];

    $conexion = new Conexion();

    $controladorUsuario = new ControladorUsuario();

    $resultado = $controladorUsuario->iniciarSesionUsuario($usuario,$conexion);

    if($resultado != false){
        $_SESSION["nombre"] = $resultado["nombre"];
        $_SESSION["usuario"] = $resultado["usuario"];
        $_SESSION["email"] = $resultado["email"];
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
			<strong><a href='javascript:history.back()'>regresar al inicio de sesión</a></strong>
		</div>
		</body>
		</html>
	<?php
	} //FIN DEL ELSE
} // FIN IF $_POST != null

?>