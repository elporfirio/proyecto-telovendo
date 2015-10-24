<?php

class Conectar 
{
	public static function conectarBaseDatos()
	{
		$db_host="localhost"; //servidor
		$db_usuario="homestead"; //usuario
		$db_password="secret"; //contraseña
		$db_nombre="venta-juegos"; //nombre de la base de datos
		
		$conexion = mysql_connect($db_host,$db_usuario,$db_password) or die(mysql_errno()." - ".mysql_error());
		mysql_query("SET NAMES 'utf8'");
		mysql_select_db($db_nombre) or die(mysql_errno()." - ".mysql_error());
		
		return $conexion;
	}
}

class consultaComentario
{
	private $comentarios = array();
	
	public function obtenerComentario($id_juego){
		$consulta = "SELECT usuarios.nombre, comentario, fecha
					FROM comentarios
					RIGHT JOIN juegos
					ON juegos.idjuegos = comentarios.id_juego
					RIGHT JOIN usuarios
					ON usuarios.idusuarios = comentarios.id_usuario
					WHERE id_juego = '$id_juego'
					ORDER BY fecha";
		
		$resultado = $this->consultaBD($consulta);
		
		while($registros = mysql_fetch_assoc($resultado)){
			$this->comentarios[] = $registros;
		}
		
		return $this->comentarios;
	}
	
	public function mostrarComentario($comentarios){
		if(sizeof($comentarios) != 0){
			$color = 0;
			foreach($comentarios as $indice => $campo_tabla){
				if ($color == 0)
					$color++;
				else
					$color--;
				echo"
				<div class=\"comment$color\">
				<img src=\"imagenes/no_avatar.jpg\" width=\"60\" height=\"60\">
				<div>
				<strong>".$campo_tabla["nombre"]."</strong><br>
				<p>".$campo_tabla["comentario"]."</p>
				<span class=\"fecha_comentario\">".$campo_tabla["fecha"]."</span>
				<div class=\"clr\"></div>
				</div>
				</div>
				
				";
			}
		}
		else{
			echo "no hay comentarios registrados";
		}	
	}
	
	public function registrarComentario($id_usuario, $id_juego, $comentario, $fecha){
		
		$consulta = "INSERT INTO comentarios (`id_usuario`, `id_juego`, `comentario`, `fecha`)
					VALUES ('$id_usuario', '$id_juego', '$comentario', '$fecha')";
		
		return $this->consultaBD($consulta);
	}
	
	private function consultaBD($consulta){
		$resultado = mysql_query($consulta, Conectar::conectarBaseDatos()) or die (mysql_error());
		return $resultado;
		mysql_free_result($consulta);
	}
}

class consultaUsuario
{
	private $usuarios = array();
	
	public function comprobarUsuario($usuario, $contrasena){
	
		$consulta = "SELECT *
					FROM usuarios
					WHERE usuario = '$usuario'
					AND contrasena ='$contrasena'";
		
		$resultado = $this->consultaBD($consulta);
		
		while($registros = mysql_fetch_assoc($resultado)){
			$this->usuarios[] = $registros;
		}
		
		return $this->usuarios;
					
	}
	
	public function registrarUsuario($nombre, $usuario, $contrasena, $email){
		
		$consulta = "INSERT INTO usuarios (`nombre`, `usuario`, `contrasena`, `email`)
					VALUES ('$nombre', '$usuario', '$contrasena', '$email')";
		
		return $this->consultaBD($consulta);
	}
	
	private function consultaBD($consulta){
		$resultado = mysql_query($consulta, Conectar::conectarBaseDatos()) or die (mysql_error());
		return $resultado;
		mysql_free_result($consulta);
	}
	
}

class consultaConsola
{
	private $consolas = array();
	
	public function obtenerConsola(){
		$consulta = "SELECT * FROM cat_consolas ORDER BY nombre DESC";
		
		$resultado = $this->consultaBD($consulta);
		
		while($registros = mysql_fetch_assoc($resultado)){
			$this->consolas[] = $registros;
		}
		
		return $this->consolas;
	}
	
	private function consultaBD($consulta){
		$resultado = mysql_query($consulta, Conectar::conectarBaseDatos()) or die (mysql_error());
		return $resultado;
		mysql_free_result($consulta);
	}
}

class consultaGenero
{
	private $generos= array();
	
	public function obtenerGenero(){
		$consulta = "SELECT * FROM cat_generos ORDER BY nombre";
		
		$resultado = $this->consultaBD($consulta);
		
		while($registros = mysql_fetch_assoc($resultado)){
			$this->generos[] = $registros;
		}
		
		return $this->generos;
	}
	
	private function consultaBD($consulta){
		$resultado = mysql_query($consulta, Conectar::conectarBaseDatos()) or die (mysql_error());
		return $resultado;
		mysql_free_result($consulta);
	}
}

class consultaJuego
{
	private $juegos = array();
	
	public function consultarJuego($id_usuario, $tipo){
		
		//var_dump($tipo);
		
		$consulta = "SELECT idjuegos, juegos.nombre, descripcion, portada, precio, cat_generos.nombre AS genero, cat_consolas.nombre AS consola 
					FROM juegos
					RIGHT JOIN cat_consolas
					ON juegos.idconsola = cat_consolas.idcat_consolas
					RIGHT JOIN cat_generos
					ON juegos.idgenero = cat_generos.idcat_generos";
		
		if($tipo[0] == "mios" and $id_usuario != 0)
			$consulta .= " WHERE idusuario = $id_usuario";
		
		if($tipo[0] == "todos")
			$consulta .= " WHERE idusuario != $id_usuario";
		
		if($tipo[0] == "detalle"){
			$consulta .= " WHERE idjuegos ='".$tipo[1]."'";
		}
		
		$consulta .= " ORDER BY idjuegos DESC LIMIT 5";
		
		//echo $consulta;
		
		$resultado = $this->consultaBD($consulta);
		
		while($registros = mysql_fetch_assoc($resultado)){
			$this->juegos[] = $registros;
		}
		return $this->juegos;
	}
	
	public function registrarJuego($id_usuario, $nombre_juego, $id_consola, $id_genero, $descripcion, $portada, $precio){
		
		$archivo = $this->moverArchivos($portada);
		
		if(sizeof($archivo) > 0)
			$ubicacion = $archivo[0];
		else
			$ubicacion = null;
		
		$consulta = "INSERT INTO juegos (`idusuario`, `nombre`, `idconsola`, `idgenero`, `descripcion`,`portada`, `precio`) 
					VALUES ('$id_usuario', '$nombre_juego', '$id_consola', '$id_genero', '$descripcion', '$ubicacion','$precio')";
		
		//echo($consulta);
		return $this->consultaBD($consulta);
	}
	
	public function mostrarJuegos($juegos){
		if(sizeof($juegos) != 0){
			foreach($juegos as $indice => $campo_tabla){
				echo "
				<div class=\"muestra_juego\">
					<h4>".substr($campo_tabla["nombre"], 0, 30)."</h4>";
				if($campo_tabla["portada"] != ""){
					echo "<img src=\"upload/".$campo_tabla["portada"]."\" width=\"155\" height=\"222\">";
				}
				else {
					echo "<img src=\"imagenes/sin_imagen.jpg\" width=\"155\" height=\"222\">";
				}
				echo "
					<div class=\"dato_consola\">".$campo_tabla["consola"]."</div>
					<div class=\"dato_precio\">$ ".$campo_tabla["precio"]."</div>
					<div class=\"dato_genero\">genero: ".$campo_tabla["genero"]."</div>
					<div class=\"clr\"></div>
					<div class=\"dato_descripcion\">".substr($campo_tabla["descripcion"], 0, 60)."</div>
					<div class=\"clr\"></div>
					<a href='ver_juego.php?j=".base64_encode($campo_tabla["idjuegos"])."' class=\"dato_detalles\">Ver detalles</a>
				</div>
				";
				//echo $campo_tabla["idjuegos"]."<br>";
				//echo $campo_tabla["nombre"]."<br>";
				//echo $campo_tabla["descripcion"]."<br>";
				//echo $campo_tabla["portada"]."<br>";
				//echo $campo_tabla["precio"]."<br>";
				//echo $campo_tabla["genero"]."<br>";
				//echo $campo_tabla["consola"]."<br>";
			}
			echo "<div class=\"clr\"></div>";
		}
		else{
			echo "no hay juegos registrados";
		}	
	}
	
		public function mostrarJuegoDetalle($juegos){
		if(sizeof($juegos) != 0){
			foreach($juegos as $indice => $campo_tabla){
					echo "
				<div class=\"detalles_juego\">
				<div style=\"float: left\">";
				if($campo_tabla["portada"] != ""){
					echo "<img src=\"upload/".$campo_tabla["portada"]."\" width=\"182\" height=\"269\">";
				}
				else {
					echo "<img src=\"imagenes/sin_imagen.jpg\" width=\"182\" height=\"269\">";
				}
				echo "
				<div clas=\"clr\"></div>
				</div>
				<div style=\"float: left; width: 80%;\">
				<h1>".$campo_tabla["nombre"]."</h1>
				<div class=\"clr\"></div>";
				echo "
					<div class=\"detalle_consola\">".$campo_tabla["consola"]."</div>
					<div class=\"detalle_genero\">genero: ".$campo_tabla["genero"]."</div>
					<div class=\"detalle_precio\">$ ".$campo_tabla["precio"]."</div>
					<div class=\"clr\"></div>
					<div class=\"detalle_descripcion\">".$campo_tabla["descripcion"]."</div>
					<div class=\"clr\"></div>
				</div>
				<div class=\"clr\"></div>
				";
			}
		}
		else{
			echo "no hay juegos registrados";
		}	
	}

	
	private function consultaBD($consulta){
		$resultado = mysql_query($consulta, Conectar::conectarBaseDatos()) or die (mysql_error());
		return $resultado;
		mysql_free_result($consulta);
	}
	
	private function moverArchivos($archivos){ //Optimizada para multiples archivos
		
		//var_dump($archivos);
		$uploads_dir = "upload"; //archivos para subir
		$ubicaciones = array();
		
		//comprueba si el directorio existe y si es posible escribir
		if (file_exists($uploads_dir) && is_writable($uploads_dir)) {
			if ($archivos["error"] == 0) {
				$archivo = date("Ymd") . "_" . date("is"). "_".$archivos["name"];
				$ubicacion = $archivos["tmp_name"];
				if(!move_uploaded_file($ubicacion,"$uploads_dir/$archivo")){
					echo "No se puede mover el archivo";
				}
				else{
					$ubicaciones[] = $archivo;
				}
			}
		else{
			if($archivos["error"] != 0 and $archivos["error"] != 4){//Si no subieron archivos No enviar ninguna advertencia
				$mensaje = $this->file_upload_error_message($archivos["error"]);
				echo $mensaje." Intente nuevamente.";
				exit;
			}
		}	
			return $ubicaciones;
		}
		else {
			echo "No existe la carpeta para subir archivos o no tiene los permisos suficientes.";
		}
	}
	
	private function file_upload_error_message($error_code) {
		switch ($error_code) {
			case UPLOAD_ERR_INI_SIZE:
				return 'El archivo excede el limite permitido por la directiva de PHP';
			case UPLOAD_ERR_FORM_SIZE:
				return 'El archivo excede el limite permitido por la directiva de HTML';
			case UPLOAD_ERR_PARTIAL:
				return 'El archivo solo se subio parcialmente, intentelo de nuevo';
			case UPLOAD_ERR_NO_FILE:
				return 'No hay archivo que subir';
			case UPLOAD_ERR_NO_TMP_DIR:
				return 'El folder temporal no existe';
			case UPLOAD_ERR_CANT_WRITE:
				return 'No tiene permisos para grabar archivos en el disco';
			case UPLOAD_ERR_EXTENSION:
				return 'El archivo tiene una extensión NO permitida';
			default:
				return 'Error desconocido al subir el archivo';
		}
	}
	
}


?>