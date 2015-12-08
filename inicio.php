<?php 

session_start();

//Incluimos las clases
require_once('clases/Usuario.php');
require_once('clases/Conexion.php');
require_once('clases/ControladorUsuario.php');
require_once('clases/ControladorJuego.php');

$usuario = (isset($_SESSION["nombre"])) ? $_SESSION["nombre"] : 'visitante';
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Te lo vendo :: Página de Inicio</title>
<link href="css/estilos.css" rel="stylesheet" type="text/css">
<link href="css/formulario.css" rel="stylesheet" type="text/css">
</head>

<body>
<div id="barra_tareas">
    <div class="info_usuario"><p>Bienvenido <strong><?php echo $usuario ?></strong></p></div>
    <?php
    if(isset($_SESSION["nombre"])):
        ?>
        <div class="info_usuario"><input type="button" class="boton" value="agregar juegos" onClick="window.location.assign('nuevo_juego.php');"></div>
        <div class="cerrar_sesion"><input type="button" value="Cerrar sesion" class="boton" onClick="window.location.assign('cerrar_sesion.php');"></div>
        <?php
    endif;
    ?>
    <div class="clr"></div>
</div>
<div class="juegos">
<h2>Ultimos juegos agregados</h2>
<?php
$conexion = new Conexion();
$controladorJuego = new ControladorJuego();

$controladorJuego->consultarJuegos('', $conexion);
$controladorJuego->mostrarJuegos($controladorJuego->juegos);

?>
</div>
<?php
if(isset($_SESSION["nombre"])):
?>
<div class="juegos">
<h2>Tus juegos publicados</h2>
<?php
$controladorJuego->consultarJuegos($_SESSION["usuario"], $conexion);
$controladorJuego->mostrarJuegos($controladorJuego->juegos);
?>
</div>
    <?php
endif;
?>

</body>
</html>