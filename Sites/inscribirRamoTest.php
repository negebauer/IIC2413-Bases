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
$equivalentesintercambio = "";

$queryVerSiExtranjero = "SELECT *
						FROM alumnointercambio
						WHERE username = '{$usernameAlumno}';";
$esIntercambio = count($dbp->query($queryVerSiExtranjero));

if ($esIntercambio) {
	echo "Es intercambio<br>";
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
		echo "Curso encontrado: {$equivalencia}<br>";
		if ($equivalentesintercambio == "") {
			$equivalentesintercambio = "'" . $equivalencia . "'";
		} else {
			$equivalentesintercambio .= ", " . "'" . $equivalencia . "'";
		}
	}
	echo $equivalentesintercambio . "<br>";
}

$queryInscribirRamo = "INSERT INTO nota(username, nrc)
					(
						SELECT alumno.username, curso.nrc
						FROM alumno, curso
						WHERE alumno.username = '{$usernameAlumno}'
						AND curso.nrc = '{$nrcCurso}'
						AND (select * from AlumnoCumpleRequisitos(alumno.username, curso.sigla, ARRAY[{$equivalentesintercambio}])) = true
						AND (select * from CuposRestantes(curso.nrc)) > 0
					);";
echo $queryInscribirRamo . "<br>";

$dbp->query($queryInscribirRamo);

// TEST 2
$queryRequisitos = "select * from AlumnoCumpleRequisitos(alumno.username, curso.sigla, ARRAY[{$equivalentesintercambio}]);";
$queryRestantes = "select * from CuposRestantes(curso.nrc);";
foreach($dbp->query($queryRequisitos) as $row)
{
	echo "<tr>";
	echo "<td>" . $row[0] . "</td>";
	echo "</tr>";
}
foreach($dbp->query($queryRestantes) as $row)
{
	echo "<tr>";
	echo "<td>" . $row[0] . "</td>";
	echo "</tr>";
}

// TEST
$query2 = "select curso.nrc, sigla, seccion from curso, nota where username = '563c1a99a20c8c06c7918ba6' and curso.nrc = 99998 and nota.nrc = curso.nrc;";
foreach($dbp->query($query2) as $row)
{
	echo "<tr>";
	echo "<td>" . $row[0] . "</td>";
	echo "<td>" . $row[1] . "</td>";
	echo "<td>" . $row[2] . "</td>";
	echo "</tr>";
}

?>

<br>
<br>
<br>
<br>
<br>
<h1>Stuff</h1>

select count(*) from (SELECT MAX(nota.notafinal)
FROM nota, curso
WHERE nota.nrc = curso.nrc
AND nota.username = '563c1a99a20c8c06c7918ba6'
AND curso.sigla = 'ICC2304') >=4
OR ('ICC2304' = ANY(ARRAY['LET2437', 'ICC2453', 'LET2256', 'IIC2478', 'ICC2351', 'ICC2182', 'DPT2171', 'ICC2304']));

select nrc, ramo.sigla, nombre from curso, ramo where curso.sigla = ramo.sigla and ramo.sigla = ANY('{ICC2304, ICC2304, ICC2104, IIC2173}'::text[]);
select nrc, ramo.sigla, nombre from curso, ramo where curso.sigla = ramo.sigla and ramo.sigla = ANY('{ICC2913}'::text[]);
select sigla, nombre from ramo where ramo.sigla = ANY('{ICC2304, ICC2304, ICC2104, IIC2173}'::text[]);

select * from requisito where siglarequisito = ANY('{ICC2304, ICC2304, ICC2104, IIC2173}'::text[]);

select curso.nrc, sigla, seccion from curso, nota where username = '563c1a99a20c8c06c7918ba6' and curso.nrc = 99998 and nota.nrc = curso.nrc;

 siglaramo | siglarequisito 
-----------+----------------
 ICC2913   | ICC2304
 ICC3914   | ICC2104

ICC2304, ICC2304, ICC2104, IIC2173