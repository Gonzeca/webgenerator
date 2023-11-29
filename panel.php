<?php

	session_start();
	if (!isset($_SESSION['logged'])) {
		$_SESSION['logged'] = false;
		header("Location: http://mattprofe.com.ar:81/alumno/3892/ACTIVIDADES/CLASE_11/webgenerator/login.php");
	}
	else if (!$_SESSION['logged']) header("Location: http://mattprofe.com.ar:81/alumno/3892/ACTIVIDADES/CLASE_11/webgenerator/login.php");

	$con = mysqli_connect("localhost", "adm_webgenerator", "webgenerator2020", "webgenerator");

	if (isset($_POST['btn__submit'])) {
		$webName = $_SESSION['idUsuario'] . $_POST['webName'];
		$year = date("Y");
		$month = date("m");
		$day = date("d");
		$date = "{$year}-{$month}-{$day}";

		$ssql = "SELECT * FROM webs WHERE dominio = '{$webName}'";

		$res = mysqli_query($con, $ssql);

		if (mysqli_num_rows($res) == 0) {
			$ssql = "INSERT INTO webs (idUsuario, dominio, fechaCreacion) VALUES ('{$_SESSION['idUsuario']}', '{$webName}', '{$date}')";

			$res2 = mysqli_query($con, $ssql);

			shell_exec("../wix.sh {$webName}");
		}
	}
	
	if (isset($_POST['btn__download'])) {
		shell_exec("zip ./{$_POST['domain']}.zip {$_POST['domain']}");

		header("Location: http://mattprofe.com.ar:81/alumno/3892/ACTIVIDADES/CLASE_11/webgenerator/{$_POST['domain']}.zip");
	}

	if (isset($_POST['btn__delete'])) {
		shell_exec("rm -r ../{$_POST['domain']}");
		shell_exec("rm {$_POST['domain']}.zip");

		$ssql = "DELETE FROM webs WHERE dominio = '{$_POST['domain']}'";

		$resDelete = mysqli_query($con, $ssql);
	}

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Bienvenido a tu panel</title>
</head>
<body>
	<a href="logout.php">Cerrar sesión de <?php echo $_SESSION['idUsuario'] ?></a>

	<form method="POST">
		<h2>Generar Web de:</h2>
		<label>Nombre de Web</label>
		<input type="text" name="webName" placeholder="Nombre de Web">
		<input type="submit" name="btn__submit" value="Crear Web">
	</form>

	<?php
		if ($_SESSION['email'] == 'admin@server.com' && $_SESSION['password'] == 'serveradmin') {
			$ssql = "SELECT dominio FROM webs";

			$resList = mysqli_query($con, $ssql);

			if (mysqli_num_rows($resList) > 0) {
				echo "<ul>";
				while ($fila = mysqli_fetch_array($resList, MYSQLI_ASSOC)) {
					echo "<form method='POST'><li><a href='{$fila['dominio']}'>{$fila['dominio']}</a> <input type='hidden' name='domain' value='{$fila['dominio']}'> <input type='submit' name='btn__download' value='descargar web'> <input type='submit' name='btn__delete' value='Eliminar'></form>";
				}
				echo "</ul>";
			}
		} else {
			$ssql = "SELECT dominio FROM webs WHERE idUsuario = '{$_SESSION['idUsuario']}'";

			$resList = mysqli_query($con, $ssql);

			if (mysqli_num_rows($resList) > 0) {
				echo "<ul>";
				while ($fila = mysqli_fetch_array($resList, MYSQLI_ASSOC)) {
					echo "<form method='POST'><li><a href='{$fila['dominio']}'>{$fila['dominio']}</a> <input type='hidden' name='domain' value='{$fila['dominio']}'> <input type='submit' name='btn__download' value='descargar web'> <input type='submit' name='btn__delete' value='Eliminar'></form>";
				}
				echo "</ul>";
			}
		}

	?>
</body>
</html>