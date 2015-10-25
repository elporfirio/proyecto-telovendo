<?php
session_start();

require_once("clases/Conexion.php");
require_once("clases/ControladorJuego.php");
require_once("clases/ControladorComentario.php");



require_once("clases/class.php");

$slugjuego = base64_decode($_GET["j"]);
$conexion = new Conexion();
$controladorJuego = new ControladorJuego();

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Te lo vendo :: Detalles del juego </title>
<link href="css/estilos.css" rel="stylesheet" type="text/css">
<link href="css/formulario.css" rel="stylesheet" type="text/css">
</head>

<body>
<div id="barra_tareas">
	<div class="info_usuario"><p>Bienvenido <strong><?php echo $_SESSION["nombre"] ?></strong></p></div>
	<div class="info_usuario"><input type="button" class="boton" value="agregar juegos" onClick="window.location.assign('nuevo_juego.php');"></div>
	<div class="cerrar_sesion"><input type="button" value="Cerrar sesion" class="boton" onClick="window.location.assign('cerrar_sesion.php');"></div>
	<div class="clr"></div>
</div>
<div class="detalles">
<?php

$controladorJuego->consultarJuegos('',$conexion, $slugjuego);
$controladorJuego->mostrarJuegoDetalle($controladorJuego->juegos);

?>
<div class="comentarios">
<h2>comentarios</h2>
<?php
$controladorComentario = new ControladorComentario();
$controladorComentario->consultarComentarios($controladorJuego->juegos[0]->slug,$conexion);
$controladorComentario->mostrarComentario($controladorComentario->comentarios);

//$datos2 = new consultaComentario;
//$loscomentarios = $datos2->obtenerComentario($id_juego);
//$datos2->mostrarComentario($loscomentarios);
?>
<h4>Deja tu comentario</h4>
<form action="registrar_comentario.php" method="post">
	<input type="hidden" name="juego" value="<?php echo $slugjuego?>">
	<textarea name="comentarios" class="comenta"></textarea>
	<input type="submit" class="boton grande" value="Enviar comentario">
</form>
</div> <!-- termina class "comentarios -->
</div> <!-- DIV QUE SE QUEDA ABIERTO EN  mostrarJuegoDetalle($eljuego); -->
<a href="inicio.php">Regresar al inicio</a>
</div>
</body>
</html>