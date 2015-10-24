<?php

require_once('clases/Usuario.php');
require_once('clases/Conexion.php');
require_once('clases/ControladorUsuario.php');

if (isset($_POST)) {
    $usuario = new Usuario();

    $usuario->nombre = $_POST["nombre"];
    $usuario->email = $_POST["email"];
    $usuario->usuario = $_POST["usuario"];
    $usuario->setContrasena($_POST["contrasena"]);


    $conexion = new Conexion();

    $controladorUsuario = new ControladorUsuario();

    $resultado = $controladorUsuario->registrarUsuario($usuario, $conexion);

}
?>


<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Te lo vendo :: Usuario Registrado</title>
    <link href="css/estilos.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php


echo "<div class=\"". $controladorUsuario->claseResultado ."\"> $controladorUsuario->mensajeResultado
		<br>";

        if ($resultado != false) {
            echo "<strong><a href='login.php'>Iniciar sesión</a></strong>";
        } else {
            echo "<strong><a href='javascript:history.back()'>< Regresar</a></strong>";
        }

echo "</div>";
// FIN $_POST no nulo

?>
</body>
</html>