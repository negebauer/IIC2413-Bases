<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>RENNAB</title>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

</head>

<?php

// #################### LIBRERIAS ####################
require_once('functions.php');

// #################### VARIABLES PREDECLARADAS ####################
// Son las que puedes usar gracias a la libreria functions.php que importa global.php
// $dbm 					La base de datos de mongo
// $dbp 					La base de datos de psql
// $username 				Username de quien hace la consulta
// $arrayEsUsuario 			Verifica quien hace consulta
// $esAdmin 				Si la consulta la hace un admin
// $esAlumno 				Si la consulta la hace un alumno
// $esAlumnoIntercambio 	Si la consulta la hace un alumno de intercambio
// $esProfesor 				Si la consulta la hace un profesor

// #################### VARIABLES ####################


// #################### AHORA A HACER MAGIA ####################
if ($username == "")
{
	header("location:login.php");
}

echo "<p>Usuario actualmente conectado: $username</p><br>";

if ($esAdmin)
{
	echo "<p>Usuario actual es <b>admin</b></p><br>";
}

if ($esAlumno)
{
	echo "<p>Usuario actual es <b>alumno</b></p><br>";
}

if ($esAlumnoIntercambio)
{
	echo "<p>Usuario actual es <b>alumno intercambio</b></p><br>";
}

if ($esProfesor)
{
	echo "<p>Usuario actual es <b>profesor</b></p><br>";
}

?>