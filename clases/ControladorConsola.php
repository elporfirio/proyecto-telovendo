<?php

/**
 * Created by PhpStorm.
 * User: elporfirio
 * Date: 24/10/15
 * Time: 11:28 AM
 */

require_once('Consola.php');


class ControladorConsola
{
    public $consolas = [];

    public function obtenerConsolas(Conexion $conexion){
        $this->consolas = [];

        $consulta = "SELECT * FROM cat_consolas";

        try{
            $stmt = $conexion->acceso->prepare($consulta);

            if($stmt->execute()){
                $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($resultados as $resultado){
                    #creaamos un objeto comentario
                    $consola = new Consola();
                    $consola->id = $resultado["idcat_consolas"];
                    $consola->nombre = $resultado["nombre"];

                    $this->consolas[] = $consola;
                }
                return true;
            } else {
                $this->consolas = [];
                return false;
            }
        } catch (PDOException $ex){
            echo "<strong>Error de ejecución: </strong>" . $ex->getMessage() . "<br>";
            die();
        }
    }
}