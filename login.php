<?php

	session_start();
	
	if (!isset($_SESSION['logged'])) $_SESSION['logged'] = false;
	else if ($_SESSION['logged']) header("Location: http://mattprofe.com.ar:81/alumno/3892/ACTIVIDADES/CLASE_11/webgenerator/panel.php");
	
	if (isset($_GET['btn__submit'])) {
		$con = mysqli_connect("localhost", "adm_webgenerator", "webgenerator2020", "webgenerator");

		$ssql = "SELECT * FROM usuarios WHERE email = '{$_GET['email']}' AND password = '{$_GET['pswd']}'";

		$res = mysqli_query($con, $ssql);

		$advice = "";

		if(mysqli_num_rows($res) > 0) {
			while ($fila = mysqli_fetch_array($res, MYSQLI_ASSOC)){
				$_SESSION['idUsuario'] = $fila['idUsuario'];
				$_SESSION['email'] = $fila['email'];
				$_SESSION['password'] = $fila['password'];
			}

			$_SESSION['logged'] = true;
			header("Location: http://mattprofe.com.ar:81/alumno/3892/ACTIVIDADES/CLASE_11/webgenerator/panel.php");
		} else {
			$advice = "El usuario no ha sido encontrado";
		}
	}

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>webgenerator Gonzalo Castro</title>
</head>
<body>
	<form method="GET">
		<label for="email">Email</label>
		<input type="email" name="email" placeholder="Email">
		<label for="pswd">Contraseña</label>
		<input type="password" name="pswd" placeholder="Contraseña">
		<a href="register.php">Registrarse</a>
		<input type="submit" name="btn__submit" value="Ingresar">
	</form>
	<?php
		if (isset($_GET['btn__submit'])) {
			echo "<h4>{$advice}</h4>";
		}
	?>
</body>
</html>