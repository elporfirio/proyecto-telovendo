<?php

/**
 * Created by PhpStorm.
 * User: elporfirio
 * Date: 24/10/15
 * Time: 10:38 AM
 */

require_once('Juego.php');

class ControladorJuego
{
    public $juegos = [];
    public $claseResultado;
    public $mensajeResultado;

    public function consultarJuegos($username = '', Conexion $conexion, $juego = ''){

        $this->juegos = [];

        $consulta = "SELECT usuarios.nombre AS username, juegos.nombre AS nombre, descripcion, portada, precio, slug, cat_generos.nombre AS genero, cat_consolas.nombre AS consola
                    FROM juegos
                    LEFT JOIN usuarios
                    ON juegos.idusuario = usuarios.idusuarios
                    RIGHT JOIN cat_consolas
                    ON juegos.idconsola = cat_consolas.idcat_consolas
                    RIGHT JOIN cat_generos
                    ON juegos.idgenero = cat_generos.idcat_generos";

//        if($tipo[0] == "mios" and $id_usuario != 0)
//            $consulta .= " WHERE idusuario = $id_usuario";
//
//        if($tipo[0] == "todos")
//            $consulta .= " WHERE idusuario != $id_usuario";
//
//        if($tipo[0] == "detalle"){
//            $consulta .= " WHERE idjuegos ='".$tipo[1]."'";
//        }

        if($juego != ''){
            $consulta .= " WHERE slug = :juego";
        }

        if($username != ''){
            $consulta .= " WHERE usuarios.usuario = :username";
        }

        $consulta .= " ORDER BY fecha_creacion DESC LIMIT 5";


        try{
            $stmt = $conexion->acceso->prepare($consulta);

            if($username != '') {
                $stmt->bindParam('username', $username);
            }

            if($juego != '') {
                $stmt->bindParam('juego', $juego);
            }
            if($stmt->execute()){
                $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($resultados as $resultado){
                    #creaamos un objeto comentario
                    $juego = new Juego();
                    $juego->usuario = $resultado["username"];
                    $juego->nombre = $resultado["nombre"];
                    $juego->consola = $resultado["consola"];
                    $juego->descripcion = $resultado["descripcion"];
                    $juego->genero = $resultado["genero"];
                    $juego->portada = $resultado["portada"];
                    $juego->precio = $resultado["precio"];
                    $juego->slug = $resultado["slug"];
                    $this->juegos[] = $juego;
                }
                return true;
            } else {
                $this->juegos = [];
                return false;
            }
        } catch (PDOException $ex){
            echo "<strong>Error de ejecución: </strong>" . $ex->getMessage() . "<br>";
            die();
        }
    }

    public function mostrarJuegos($juegos){
        if(sizeof($juegos) != 0){
            foreach($juegos as $juego){
                echo "
				<div class=\"muestra_juego\">
				    <div style='height: 60px'>
				    <h4>".substr($juego->nombre, 0, 30)."</h4>
</div>";

                if($juego->portada != ""){
                    echo "<img src=\"upload/".$juego->portada."\" width=\"155\" height=\"222\">";
                }
                else {
                    echo "<img src=\"imagenes/sin_imagen.jpg\" width=\"155\" height=\"222\">";
                }
                echo "
					<div class=\"dato_consola\">".$juego->consola."</div>
					<div class=\"dato_precio\">$ ".$juego->precio."</div>
					<div class=\"dato_genero\">genero: ".$juego->genero."</div>
					<div class=\"clr\"></div>
					<div class=\"dato_descripcion\">".substr($juego->descripcion, 0, 60)."</div>
					<div class=\"clr\"></div>
					<a href='ver_juego.php?j=".base64_encode($juego->slug)."' class=\"dato_detalles\">Ver detalles</a>
				</div>
				";
            }
            echo "<div class=\"clr\"></div>";
        }
        else{
            echo "no hay juegos registrados";
        }
    }


    public function registrarJuego(Juego $juego, Conexion $conexion){
        $consulta = "INSERT INTO juegos (idusuario, nombre, idconsola, idgenero, descripcion, portada, precio, fecha_creacion, slug)
					VALUES ((SELECT idusuarios FROM usuarios WHERE usuario = :usuario), :nombre, :consola, :genero,
					 :descripcion, :portada, :precio, NOW(), :slug)";

        try {
            $stmt = $conexion->acceso->prepare($consulta);

            $archivo = $this->moverArchivos($juego->portada);

            if(sizeof($archivo) > 0)
                $ubicacion = $archivo[0];
            else
                $ubicacion = null;


            $slug = urlencode($juego->nombre);
            $stmt->bindParam(':usuario', $juego->usuario);
            $stmt->bindParam(':nombre', $juego->nombre);
            $stmt->bindParam(':consola', $juego->consola);
            $stmt->bindParam(':genero', $juego->genero);
            $stmt->bindParam(':descripcion', $juego->descripcion);
            $stmt->bindParam(':portada', $ubicacion);
            $stmt->bindParam(':precio', $juego->precio);
            $stmt->bindParam(':slug', $slug);

            if($stmt->execute()){
                $this->claseResultado = 'success';
                $this->mensajeResultado = "Juego registrado";
                return $conexion->acceso->lastInsertId(); //Devuelve el último ID que se inserta
            }

        } catch (PDOException $ex){
            echo "<strong>Error de ejecución: </strong>" . $ex->getMessage() . "<br>";
            die();
        }
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

    public function mostrarJuegoDetalle($juegos){
        if(sizeof($juegos) != 0){
            foreach($juegos as $juego) {
                echo "
            <div class=\"detalles_juego\">
            <div style=\"float: left\">";
                if ($juego->portada != "") {
                    echo "<img src=\"upload/" . $juego->portada . "\" width=\"182\" height=\"269\">";
                } else {
                    echo "<img src=\"imagenes/sin_imagen.jpg\" width=\"182\" height=\"269\">";
                }
                echo "
            <div clas=\"clr\"></div>
            </div>
            <div style=\"float: left; width: 80%;\">
            <h1>" . $juego->nombre . "</h1>
            <div class=\"clr\"></div>";
                echo "
                <div class=\"detalle_consola\">" . $juego->consola . "</div>
                <div class=\"detalle_genero\">genero: " . $juego->genero . "</div>
                <div class=\"detalle_precio\">$ " . $juego->precio . "</div>
                <div class=\"clr\"></div>
                <div class=\"detalle_descripcion\">" . $juego->descripcion . "</div>
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
}