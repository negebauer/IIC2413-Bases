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
			"<select name=usernameProfesor>"
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
		$usernameProfesor = $profesorRow[0];
		$nombresProfesor = $profesorRow[1];
		$apellidopProfesor = $profesorRow[2];
		$apellidomProfesor = $profesorRow[3];
		$infoProfesor = $nombresProfesor . " " . $apellidopProfesor . " " . $apellidomProfesor;
		$option = "<option value=$usernameProfesor>$infoProfesor</option>";
		array_push($formularioAgregarProfe, $option);
	}

	$formularioAgregarProfe = array_merge($formularioAgregarProfe, $cierreFormulario);

	imprimirLineas($formularioAgregarProfe);


	$usernameProfesorAgregado = isset($_POST['usernameProfesor']) ? $_POST['usernameProfesor'] : "";

	if ($usernameProfesorAgregado != "")
	{
		$queryAgregarProfesorACurso = "INSERT INTO profesorCurso
									VALUES ($nrcCurso, '$usernameProfesorAgregado');";

		$dbp->query($queryAgregarProfesorACurso);

		echo "<h5>Se agrego el profesor $usernameProfesorAgregado al curso con nrc $nrcCurso</h5>";
	}

}

?>