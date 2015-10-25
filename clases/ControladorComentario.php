<?php

/**
 * Created by PhpStorm.
 * User: elporfirio
 * Date: 24/10/15
 * Time: 7:04 PM
 */
class ControladorComentario
{
    public $comentarios = [];

    public function consultarComentarios($slugjuego = '', Conexion $conexion){
        $this->comentarios = [];

        $consulta = "SELECT usuarios.usuario, comentario, fecha
					FROM comentarios
					RIGHT JOIN juegos
					ON juegos.idjuegos = comentarios.id_juego
					RIGHT JOIN usuarios
					ON usuarios.idusuarios = comentarios.id_usuario
					WHERE slug = :slug
					ORDER BY fecha";

        try{
            $stmt = $conexion->acceso->prepare($consulta);

            $stmt->bindParam('slug', $slugjuego);
            if($stmt->execute()){
                $resultados = $stmt->fetchAll();
                foreach($resultados as $resultado){
                    #creaamos un objeto comentario
                    $comentario = new Comentario();
                    $comentario->usuario = $resultado["username"];
                    $comentario->nombre = $resultado["nombre"];
                    $comentario->consola = $resultado["consola"];

                    $this->comentarios[] = $comentario;
                }
                return true;
            } else {
                $this->comentarios = [];
                return false;
            }
        } catch (PDOException $ex){
            echo "<strong>Error de ejecución: </strong>" . $ex->getMessage() . "<br>";
            die();
        }

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

    public function registrarComentario($usuario, $juego, Comentario $comentario, Conexion $conexion){

        $consulta = "INSERT INTO comentarios (`id_usuario`, `id_juego`, `comentario`, `fecha`)
					VALUES ('$id_usuario', '$id_juego', '$comentario', '$fecha')";

        return $this->consultaBD($consulta);
    }
}