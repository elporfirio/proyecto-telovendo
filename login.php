<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Te lo vendo :: Iniciar sesión</title>
<link href="css/estilos.css" rel="stylesheet" type="text/css">
<link href="css/formulario.css" rel="stylesheet" type="text/css">
</head>

<body>
<div class="cuadro_azul">
	<h1>Ingresa tus datos</h1>
	<form name="form1" method="post" action="iniciar_sesion.php">
		<label for="usuario">usuario</label>
		<input type="text" name="usuario" id="usuario" class="texto">
		<label for="contrasena">contraseña</label>
		<input type="password" name="contrasena" id="contrasena" class="texto">
		<div class="clr"></div>
		<input type="submit" class="boton" name="ingresar" id="ingresar" value="Entrar al sistema">
	</form>
	<br />
	<a href="nuevo_usuario.php">¿nuevo usuario?, <strong>registrate aquí</strong></a>
</div>
</body>
</html>