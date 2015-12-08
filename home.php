<?php

session_start();

//Incluimos las clases
require_once('clases/Usuario.php');
require_once('clases/Conexion.php');
require_once('clases/ControladorUsuario.php');
require_once('clases/ControladorJuego.php');
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
    <link href="css/estilos.css" rel="stylesheet" type="text/css">
</head>

<body>
<div class="juegos">
    <h2>Ultimos juegos agregados</h2>
    <?php
    $conexion = new Conexion();
    $controladorJuego = new ControladorJuego();

    $controladorJuego->consultarJuegos('', $conexion);
    $controladorJuego->mostrarJuegos($controladorJuego->juegos);

    ?>
</div>
<div class="juegos">
<h4>Ultimos agregados en XBOX</h4>
    <?php
    $controladorJuego->consultarJuegos('', $conexion, '', [2,8]);
    $controladorJuego->mostrarJuegos($controladorJuego->juegos);
    ?>
</div>
<div class="juegos">
<h4>Ultimos agregados en PlayStation</h4>
    <?php
    $controladorJuego->consultarJuegos('', $conexion, '', [1,6,4]);
    $controladorJuego->mostrarJuegos($controladorJuego->juegos);
    ?>
</div>
<div class="juegos">
<h4>Ultimos agregados en Nintendo</h4>
    <?php
    $controladorJuego->consultarJuegos('', $conexion, '', [5,3,7]);
    $controladorJuego->mostrarJuegos($controladorJuego->juegos);
    ?>
</div>
</body>
</html>