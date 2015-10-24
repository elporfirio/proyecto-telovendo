<?php
require_once("clases/class.php");

//print_r($_POST);

if(isset($_POST)){
	$nombre = $_POST["nombre"];
	$usuario = $_POST["usuario"];
	$contrasena = $_POST["contrasena"];
	$email = $_POST["email"];
	
	$datos = new consultaUsuario();
	
	$nuevo_usuario = $datos->registrarUsuario($nombre, $usuario, $contrasena, $email);
	
	//var_dump($nuevo_usuario);
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

	if($nuevo_usuario)
		echo "<div class=\"success\">Nuevo usuario registrado
				<br>
				<strong><a href='login.php'>Iniciar sesi&oacute;n</a></strong></div>";
	} // FIN $_POST no nulo

?>
</body>
</html>