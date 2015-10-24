<?php 
session_start();
//print_r($_SESSION);

require_once('clases/class.php');

$datos = new consultaConsola;
$consolas = $datos->obtenerConsola();

$datos = new consultaGenero;
$generos = $datos->obtenerGenero();

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
	<label for="nombre_juego">Nombre</label>
	<input name="nombre_juego" type="text" value="" class="texto">
	
	
	<select name="consola_juego">
		<option value="no_valido">- Seleccione una consola -</option>
		<?php
		foreach($consolas as $indice => $contenido){
				echo "<option value=\"".$contenido['idcat_consolas']."\">".$contenido['nombre']."</option>";
			}
		?>
	</select>
	<select name="genero_juego">
		<option value="no_valido">- Seleccione un género -</option>
		<?php
		foreach($generos as $indice => $contenido){
				echo "<option value=\"".$contenido['idcat_generos']."\">".$contenido['nombre']."</option>";
			}
		?>
	</select>
	<label for="descripcion_juego">Descripción</label>
	<textarea name="descripcion_juego" class="descripcion_juego"></textarea>
	<div class="custom-input-file boton"><input type="file" size="1" class="input-file" name="portada_juego"/>
    Agregar portada
</div> 
<div class="clr"></div>
	<label for="precio_juego">Precio</label>
	<input name="precio_juego" type="text" class="texto" maxlength="6">
	<input type="submit" value="Colocar nuevo juego" class="boton">
</form>
</div>
</body>
</html>
