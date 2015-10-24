<?php

/**
 * Created by PhpStorm.
 * User: elporfirio
 * Date: 24/10/15
 * Time: 8:25 AM
 */
class Conexion
{
    private $domain = "localhost";
    private $database = "venta-juegos";
    private $user = "homestead";
    private $password = "secret";

    public $acceso = null;

    public function __construct(){
        try {
            $this->acceso = new PDO(
                'mysql:host=' . $this->domain . ';dbname=' . $this->database .';port=3306',
                $this->user,
                $this->password,
                array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            );
            //$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex){
            echo "<strong>Error de Conexión: </strong>" . $ex->getMessage() . "<br>";
            die();
        }
    }
}