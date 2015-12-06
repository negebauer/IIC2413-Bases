<?php

// #################### LIBRERIAS ####################
require_once('functions.php');

// #################### VARIABLES ####################
$usernameAlumno = "testuser1";
$nrcCurso = 14352;

// #################### INSCRIBIR RAMO ####################
$equivalentesintercambio = "";
$queryVerSiExtranjero = "SELECT *
						FROM alumnointercambio
						WHERE username = '{$usernameAlumno}';";
$esIntercambio = false;
if (count($dbp->query($queryVerSiExtranjero)->fetchAll()) > 0) {
	$esIntercambio = true;
}

if ($esIntercambio) {
	$alumnos = $dbm->alumnos;
	$cursos = $dbm->cursos;
	$mongoid = new MongoId($usernameAlumno);
	$idQuery = array("_id" => $mongoid);
	$alumnosMatch = $alumnos->find($idQuery);
	$alumnosMatch->next();
	$alumno = $alumnosMatch->current();
	
	$cursosAlumno = $cursos->find(array('_id' => array('$in' => $alumno["cursos"])));

	foreach (iterator_to_array($cursosAlumno) as $curso)
	{
		$equivalencia = $curso["equivalencia"];
		if ($equivalentesintercambio == "") {
			$equivalentesintercambio = "'" . $equivalencia . "'";
		} else {
			$equivalentesintercambio .= ", " . "'" . $equivalencia . "'";
		}
	}
}

$queryCumpleRequisitos = "SELECT alumno.username, curso.nrc
						FROM alumno, curso
						WHERE alumno.username = '{$usernameAlumno}'
						AND curso.nrc = {$nrcCurso}
						AND (select * from AlumnoCumpleRequisitos(alumno.username, curso.sigla, ARRAY[{$equivalentesintercambio}]::text[])) = true
						AND (select * from CuposRestantes(curso.nrc)) > 0;";
$queryInscribirRamo = "INSERT INTO nota(username, nrc)
					(
						{$queryCumpleRequisitos}
					);";
$queryInscribirRamo . "<br>";

if (!($dbp->query($queryInscribirRamo) instanceof PDO)) {
	// No cumple requisitos
	echo "No cumple requisitos";
} else {
	// Cumple requisitos
	echo "Cumple requisitos";
	$dbp->query($queryInscribirRamo);
}

?>