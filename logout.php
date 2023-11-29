<?php

	session_start();

	unset($_SESSION['idUsuario']);
	unset($_SESSION['email']);
	unset($_SESSION['password']);
	$_SESSION['logged'] = false;

	header("Location: http://mattprofe.com.ar:81/alumno/3892/ACTIVIDADES/CLASE_11/webgenerator/login.php");

?>