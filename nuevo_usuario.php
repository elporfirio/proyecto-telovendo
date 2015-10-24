<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Te lo vendo :: Datos para nuevo usuario</title>
    <link href="css/estilos.css" rel="stylesheet" type="text/css">
    <link href="css/formulario.css" rel="stylesheet" type="text/css">
</head>

<body>
<div class="cuadro_azul">
    <h2>Usuario nuevo</h2>

    <form action="registrar_usuario.php" method="post">
        <label for="nombre">nombre</label>
        <input name="nombre" type="text" class="texto" required>
        <label for="usuario">usuario</label>
        <input name="usuario" type="text" class="texto" required>
        <label for="contrasena">contraseña</label>
        <input name="contrasena" type="password" class="texto" required>
        <label for="email">e-mail</label>
        <input name="email" type="email" class="texto" required>

        <div class="clr"></div>
        <input type="submit" value="Registrar nuevo usuario" class="boton submit">
    </form>
</div>
</body>
</html>