<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>RENNAB</title>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

</head>	

<?php

// #################### LIBRERIAS ####################
require_once('functions.php');

// #################### VARIABLES ####################
$usernameAlumno = "";		// username del alumno sobre el cual se hace la consulta.
							// Si user es alumno entonces (username = usernameAlumno).

// #################### AHORA A HACER MAGIA ####################
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $usernameAlumno = intval($_POST['usernameAlumno']);	
}

if ($esAlumno)
{
	$usernameAlumno = $username;
}

if ($esAlumno || $esAdmin || $esProfesor)
{
	// ##### Declaramos las consultas #####
	$queryInfoAlumno = "SELECT usuario.rut, usuario.username, usuario.nombres, usuario.apellidop, usuario.apellidom, alumno.mailuc, alumno.anoadmin, alumno.encausal 
						FROM usuario, alumno
						WHERE usuario.username = alumno.username
						AND alumno.username = '{$usernameAlumno}';";
	
	$queryCursosAlumno = "SELECT curso.nrc, curso.sigla, curso.seccion, ramo.nombre, curso.ano, curso.semestre, nota.notafinal
						FROM nota, ramo, curso
						WHERE nota.username = '{$usernameAlumno}'
						AND nota.nrc = curso.nrc
						AND ramo.sigla = curso.sigla
						ORDER BY curso.ano, curso.semestre, curso.sigla, ramo.nombre;";

	// ##### Hacemos las consultas #####
	$informacionAlumnoRowArray = $dbp->query($queryInfoAlumno)->fetchAll();
	$cursosRowArray = $dbp->query($queryCursosAlumno)->fetchAll();

	// ##### Tabla información alumno #####
	$columnas = array (
		"RUT",
		"Usuario",
		"Nombres",
		"Apellido Paterno",
		"Apellido Materno",
		"Mail UC",
		"Año admision",
		"En causal"
		);
	imprimirTabla($columnas, $informacionAlumnoRowArray);

	// ##### Tabla información cursos del alumno #####
	$columnas = array(
		"NRC",
		"Sigla",
		"Seccion",
		"Nombre ramo",
		"Año",
		"Semestre",
		"Nota"
		);
	imprimirTabla($columnas, $cursosRowArray, 0, "informacionCurso.php", "nrcCurso");

}

?>