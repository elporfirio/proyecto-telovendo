<?php

/**
 * Created by PhpStorm.
 * User: elporfirio
 * Date: 24/10/15
 * Time: 11:28 AM
 */
require_once('Genero.php');
class ControladorGenero
{
    public $generos = [];

    public function obtenerGeneros(Conexion $conexion){
        $this->generos = [];

        $consulta = "SELECT * FROM cat_generos";

        try{
            $stmt = $conexion->acceso->prepare($consulta);

            if($stmt->execute()){
                $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($resultados as $resultado){
                    #creaamos un objeto comentario
                    $genero = new Genero();
                    $genero->id = $resultado["idcat_generos"];
                    $genero->nombre = $resultado["nombre"];

                    $this->generos[] = $genero;
                }
                return true;
            } else {
                $this->generos = [];
                return false;
            }
        } catch (PDOException $ex){
            echo "<strong>Error de ejecución: </strong>" . $ex->getMessage() . "<br>";
            die();
        }
    }
}