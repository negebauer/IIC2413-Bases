<?php

// #################### DELCARACION BASES DE DATOS ####################
$dbhost = "localhost";
$dbname = "test";
$mongo = new MongoClient("mongodb://$dbhost");
$dbm = $mongo->$dbname;

try {
	$dbp = new PDO("pgsql:dbname=grupo5;host=localhost;port=5432;user=grupo5;password=gruponico");
}
catch(PDOException $e) {
	echo $e->getMessage();
}

// #################### VARIABLES POR DESIGNAR ####################
// $usernameAlumno = "563c1a99a20c8c06c7918ba6";
// $nrcCurso = 99998;

$usernameAlumno = "testuser1";
$nrcCurso = 14352;

// #################### INSCRIBIR RAMO ####################
$equivalentesintercambio = "";
$queryVerSiExtranjero = "SELECT *
						FROM alumnointercambio
						WHERE username = '{$usernameAlumno}';";
$esIntercambio = count($dbp->query($queryVerSiExtranjero));

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

$queryInscribirRamo = "INSERT INTO nota(username, nrc)
					(
						SELECT alumno.username, curso.nrc
						FROM alumno, curso
						WHERE alumno.username = '{$usernameAlumno}'
						AND curso.nrc = {$nrcCurso}
						AND (select * from AlumnoCumpleRequisitos(alumno.username, curso.sigla, ARRAY[{$equivalentesintercambio}]::text[])) = true
						AND (select * from CuposRestantes(curso.nrc)) > 0
					);";
$queryInscribirRamo . "<br>";

$dbp->query($queryInscribirRamo);

?>