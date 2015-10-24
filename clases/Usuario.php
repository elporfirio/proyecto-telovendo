<?php

/**
 * Created by PhpStorm.
 * User: elporfirio
 * Date: 24/10/15
 * Time: 8:23 AM
 */
class Usuario
{
    public $nombre;
    public $usuario;
    private $contrasena;
    public $email;

    public function setContrasena($string){
        $this->contrasena = md5($string);
    }

    public function getContrasena(){
        return $this->contrasena;
    }
}