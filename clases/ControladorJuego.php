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

    public function consultarJuegos($username = '', Conexion $conexion){

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

        if($username != ''){
            $consulta .= " WHERE usuarios.usuario = :username";
        }

        $consulta .= " ORDER BY fecha_creacion DESC LIMIT 5";


        try{
            $stmt = $conexion->acceso->prepare($consulta);

            if($username != '') {
                $stmt->bindParam('username', $username);
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
}