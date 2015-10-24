<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
<script>
function redireccionar(){
	alert("Sección en construcción es necesario que te registres o inicies sesión");
	window.location.href="login.php";	
	}
</script>
</head>

<body onload="redireccionar();">
<div>
<h2>Ultimos agregados</h2>
<a href="lista_juegos.php">ver todos los juegos</a>
</div>
<div>
<h4>Ultimos agregados en XBOX</h4>
<a href="lista_juegos.php">ver todos los juegos de XBOX</a>
</div>
<div>
<h4>Ultimos agregados en PS3</h4>
<a href="lista_juegos.php">ver todos los juegos de PS3</a>
</div>
<div>
<h4>Ultimos agregados en Wii</h4>
<a href="lista_juegos.php">ver todos los juegos de Wii</a>
</div>
</body>
</html>