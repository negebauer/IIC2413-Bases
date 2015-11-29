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
$usernameAlumno = "563c1a99a20c8c06c7918ba6";
$nrcCurso = 99998;
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

select nrc, ramo.sigla, nombre from curso, ramo where curso.sigla = ramo.sigla and ramo.sigla = ANY('{ICC2304, ICC2304, ICC2104, IIC2173}'::text[]);
select nrc, ramo.sigla, nombre from curso, ramo where curso.sigla = ramo.sigla and ramo.sigla = ANY('{ICC2913}'::text[]);
select sigla, nombre from ramo where ramo.sigla = ANY('{ICC2304, ICC2304, ICC2104, IIC2173}'::text[]);

select * from requisito where siglarequisito = ANY('{ICC2304, ICC2304, ICC2104, IIC2173}'::text[]);

 siglaramo | siglarequisito 
-----------+----------------
 ICC2913   | ICC2304
 ICC3914   | ICC2104

ICC2304, ICC2304, ICC2104, IIC2173