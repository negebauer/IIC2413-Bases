<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>RENNAB</title>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

</head>

<?php

// #################### LIBRERIAS ####################
require_once('functions.php');

// #################### VARIABLES ####################
$nrcCurso = intval($_POST['nrcCurso']);

// #################### AHORA A HACER MAGIA ####################
if ($esAdmin)
{

	$formularioAgregarProfe = array(
		"<form action='agregarProfesorACurso.php' method='post'>",
			"<input class=hidden name=nrcCurso value=$nrcCurso>",
			"<select name=profesorSeleccionado"
	);

	$cierreFormulario = array(
			"</select>",
			"<input type='submit' name='submit' value='Agregar profesor al curso'>",
		"</form>"
	);

	$queryProfesores = "SELECT profesor.username, nombres, apellidop, apellidom
						FROM usuario, profesor
						WHERE usuario.username = profesor.username
						ORDER BY apellidop ASC, apellidom ASC, nombres ASC;";

	$profesoresRowArray = $dbp->query($queryProfesores)->fetchAll();

	foreach ($profesoresRowArray as $profesorRow) {
		$username = $profesorRow[0];
		$nombres = $profesorRow[1];
		$apellidop = $profesorRow[2];
		$apellidom = $profesorRow[3];
		$infoProfe = $nombres . " " . $apellidop . " " . $apellidom;
		$option = "<option value=$username>$infoProfe</option>";
		array_push($formularioAgregarProfe, $option);
	}

	$formularioAgregarProfe = array_merge($formularioAgregarProfe, $cierreFormulario);

	imprimirLineas($formularioAgregarProfe);

}

?>