<?php 
session_start();
//print_r($_SESSION);

require_once('clases/Conexion.php');
require_once('clases/ControladorConsola.php');
require_once('clases/ControladorGenero.php');


$conexion = new Conexion();
$controladorConsola = new ControladorConsola();
$controladorGenero = new ControladorGenero();

$controladorConsola->obtenerConsolas($conexion);
$controladorGenero->obtenerGeneros($conexion);

$consolas = $controladorConsola->consolas;
$generos = $controladorGenero->generos;

?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Te lo vendo :: Registrar nuevo juego</title>
<link href="css/estilos.css" rel="stylesheet" type="text/css">
<link href="css/formulario.css" rel="stylesheet" type="text/css">
</head>

<body>
<div class="cuadro_azul">
<h2>Juego nuevo</h2>
<form action="registrar_juego.php" method="post" enctype="multipart/form-data">
	<label for="nombre">Nombre</label>
	<input name="nombre" type="text" value="" class="texto" required>
	
	
	<select name="consola" required>
		<option value="">- Seleccione una consola -</option>
		<?php
		foreach($consolas as $consola){
				echo "<option value=\"".$consola->id."\">".$consola->nombre."</option>";
			}
		?>
	</select>
	<select name="genero" required>
		<option value="">- Seleccione un género -</option>
		<?php
		foreach($generos as $genero){
				echo "<option value=\"".$genero->id."\">".$genero->nombre."</option>";
			}
		?>
	</select>
	<label for="descripcion">Descripción</label>
	<textarea name="descripcion" class="descripcion" required></textarea>
    <label for="portada">Portada</label>
    <div class="">
        <input type="file" size="1" class="input-file" name="portada"/>
    </div>
    <br>
<div class="clr"></div>
	<label for="precio">Precio</label>
	<input name="precio" type="text" class="texto" maxlength="6" required>
	<button type="submit" class="boton"> Crear nuevo juego</button>
</form>
</div>
</body>
</html>
