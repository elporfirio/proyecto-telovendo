<?php

/**
 * Created by PhpStorm.
 * User: elporfirio
 * Date: 24/10/15
 * Time: 8:27 AM
 */
class ControladorUsuario
{
    public $mensajeResultado;
    public $claseResultado;

    public function iniciarSesionUsuario(Usuario $usuario, Conexion $conexion){
        $consulta = "SELECT usuario, email, nombre FROM usuarios
					 WHERE usuario = :usuario AND contrasena = :contrasena";

        try {
            $stmt = $conexion->acceso->prepare($consulta);

            $contrasena_encriptada = $usuario->getContrasena();

            $stmt->bindParam(':usuario', $usuario->usuario);
            $stmt->bindParam(':contrasena', $contrasena_encriptada);

            if($stmt->execute()){
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }

        } catch (PDOException $ex){
            echo "<strong>Error de ejecución: </strong>" . $ex->getMessage() . "<br>";
            die();
        }

    }

    public function registrarUsuario(Usuario $usuario, Conexion $conexion){

        /* Verificar duplicidad de nombre de usuario */
        $resultadoDuplicidadUsuario = $this->consultarExistenciaUsuario($usuario, $conexion);

        if(intval($resultadoDuplicidadUsuario) > 0){
            $this->claseResultado = 'error';
            $this->mensajeResultado = "El usuario ya existe";
            return false;
        }


        $resultadoDuplicidadEmail = $this->consultarExistenciaCorreo($usuario, $conexion);

        if(intval($resultadoDuplicidadEmail) > 0){
            $this->claseResultado = 'error';
            $this->mensajeResultado = "El email ya existe";
            return false;
        }

        $consulta = "INSERT INTO usuarios (nombre, usuario, contrasena, email)
					VALUES (:nombre, :usuario, :contrasena, :email)";

        try {
            $stmt = $conexion->acceso->prepare($consulta);

            $contrasena_encriptada = $usuario->getContrasena();

            $stmt->bindParam(':nombre', $usuario->nombre);
            $stmt->bindParam(':usuario', $usuario->usuario);
            $stmt->bindParam(':contrasena', $contrasena_encriptada);
            $stmt->bindParam(':email', $usuario->email);

            if($stmt->execute()){
                $this->claseResultado = 'success';
                $this->mensajeResultado = "Usuario registrado";
                return $conexion->acceso->lastInsertId(); //Devuelve el último ID que se inserta
            }

        } catch (PDOException $ex){
            echo "<strong>Error de ejecución: </strong>" . $ex->getMessage() . "<br>";
            die();
        }
    }

    private function consultarExistenciaUsuario(Usuario $usuario, Conexion $conexion){
        $consulta = "SELECT count(usuario) as cantidad FROM usuarios
                      WHERE usuario = :usuario";

        try {
            $stmt = $conexion->acceso->prepare($consulta);

            $stmt->bindParam(':usuario', $usuario->usuario);

            if($stmt->execute()){
                return $stmt->fetchColumn();
            }

        } catch (PDOException $ex){
            echo "<strong>Error de ejecución: </strong>" . $ex->getMessage() . "<br>";
            die();
        }
    }

    private function consultarExistenciaCorreo(Usuario $usuario, Conexion $conexion){
        $consulta = "SELECT count(usuario) FROM usuarios WHERE email = :email";

        try {
            $stmt = $conexion->acceso->prepare($consulta);

            $stmt->bindParam(':email', $usuario->email);

            if($stmt->execute()){
                return $stmt->fetchColumn();
            }

        } catch (PDOException $ex){
            echo "<strong>Error de ejecución: </strong>" . $ex->getMessage() . "<br>";
            die();
        }
    }
}