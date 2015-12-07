<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>RENNAB</title>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

</head>

<?php

// #################### LIBRERIAS ####################
require_once('functions.php');

// #################### VARIABLES ####################


// #################### AHORA A HACER MAGIA ####################
if ($esAdmin || $esProfesor)
{

	$queryAlumnos = "SELECT usuario.rut, usuario.username, usuario.nombres, usuario.apellidop, usuario.apellidom,
						alumno.mailuc, alumno.anoadmin, alumno.encausal 
					FROM usuario, alumno
					WHERE usuario.username = alumno.username
					ORDER BY apellidop, apellidom, nombres;";

	$alumnosRowArray = $dbp->query($queryAlumnos)->fetchAll();

	$columnas = array(
		"RUT",
		"Usuario",
		"Nombres",
		"Apellido Paterno",
		"Apellido Materno",
		"Mail UC",
		"Año admision",
		"En causal"
	);
	imprimirTabla($columnas, $alumnosRowArray, 1, "informacionAlumno.php", "usernameAlumno");

}
else
{
	header("location:index.php");
}

?>