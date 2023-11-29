<?php

	session_start();
	if (!isset($_SESSION['logged'])) $_SESSION['logged'] = false;
	else if ($_SESSION['logged']) header("Location: http://mattprofe.com.ar:81/alumno/3892/ACTIVIDADES/CLASE_11/webgenerator/panel.php");

	$advice = "";

	if (isset($_POST['btn__submit'])) {
		if ($_POST['pswd'] != $_POST['pswdrpt']) $advice = "Las contraseñas no coinciden";
		else {
			$con = mysqli_connect("localhost", "adm_webgenerator", "webgenerator2020", "webgenerator");

			$ssql = "SELECT * FROM usuarios WHERE email = '{$_POST['email']}'";

			$res = mysqli_query($con, $ssql);

			if (mysqli_num_rows($res) > 0) $advice = "Este usuario ya existe";
			else {
				$year = date("Y");
				$month = date("m");
				$day = date("d");
				$date = "{$year}-{$month}-{$day}";
				$ssql = "INSERT INTO usuarios (email, password, fechaRegistro) VALUES ('{$_POST['email']}', '{$_POST['pswd']}', '{$date}')";

				$res2 = mysqli_query($con, $ssql);

				$advice = "Operación exitosa";

				header("Location: http://mattprofe.com.ar:81/alumno/3892/ACTIVIDADES/CLASE_11/webgenerator/login.php");
			}
		}
	}

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Registrarte es simple.</title>
</head>
<body>
	<form method="POST">
		<label for="email">Email</label>
		<input type="email" name="email" placeholder="Email">
		<label for="pswd">Contraseña</label>
		<input type="password" name="pswd" placeholder="Contraseña">
		<label for="pswdrpt">Repetir contraseña</label>
		<input type="password" name="pswdrpt" placeholder="Repetir contraseña">
		<input type="submit" name="btn__submit" value="Ingresar">
	</form>
	<?php
		if (isset($_POST['btn__submit'])) echo "<h4>{$advice}</h4>";
	?>
</body>
</html>