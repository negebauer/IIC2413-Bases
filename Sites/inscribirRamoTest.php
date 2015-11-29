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

// #################### INSCRIBIR RAMO ####################
$usernameAlumno = "563c1a99a20c8c06c7918b3f"
$nrcCurso = ""
$equivalentesintercambio = [];

$queryVerSiExtranjero = "SELECT *
						FROM alumnointercambio
						WHERE username = '{$usernameAlumno}';";
$esIntercambio = $dbp->query($queryVerSiExtranjero)->count();

if ($esIntercambio) {
	echo "Es intercambio<br>";
}

$queryInscribirRamo = "INSERT INTO nota(username, nrc)
					(
						SELECT alumno.username, curso.nrc
						FROM alumno, curso
						WHERE alumno.username = '{$usernameAlumno}'
						AND curso.nrc = '{$nrcCurso}'
						AND (select * from AlumnoCumpleRequisitos(alumno.username, curso.sigla, {$equivalentesintercambio})) = true
						AND (select * from CuposRestantes(curso.nrc)) > 0
					);";

?>