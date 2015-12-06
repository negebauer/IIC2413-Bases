<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>RENNAB</title>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

</head>

<?php

// #################### LIBRERIAS ####################
require_once('functions.php');

// #################### AGREGAR ALUMNOS DE INTERCAMBIO A BASE DE DATOS ####################
$alumnos = $dbm->alumnos->find();
foreach (iterator_to_array($alumnos) as $alumno)
{
	// Sacamos la info del alumno
	$nombreRaw = $alumno["nombre"];
	$splited = explode(" ", $nombreRaw);
	$nombre = $splited[0];
	$apellido = $splited[1];
	$email = $alumno["email"];
	$universidad = $alumno["universidad"];
	$direccion = $alumno["direccion"];
	$id = $alumno["_id"];

	// Nos preparamos para agregar al alumno a nuestra base de datos
	$query = "INSERT INTO usuario
			VALUES ('{$id}', 1234, '{$direccion}', '{$email}', '', '', '', '{$nombre}', '{$apellido}', '', 0, null);
			INSERT INTO alumno
			VALUES ('{$id}', '', 0, 2015, false);
			INSERT INTO alumnointercambio
			VALUES ('{$id}', '{$universidad}');";

	$dbp->query($query);

}

// #################### AGREGAR CURSOS EQUIVALENTES A LA BASE DE DATOS CON NOMBRE EXTRANJERO ####################
$cursos = $dbm->cursos->find();
foreach (iterator_to_array($cursos) as $curso)
{
	$sigla = $curso["equivalencia"];
	$nombre = $curso["nombre"];
	$query = "INSERT INTO ramo
			VALUES ('{$sigla}', '{$nombre}', 10, 'EscuelaNoIdentificada');";
	$dbp->query($query);
}

?>