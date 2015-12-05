<?php

// #################### DECLARACION BASES DE DATOS ####################
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
$username = "testuser1";			// username de quien hace la consulta
$usernameAlumno = "testuser1";		// username del alumno sobre el cual se hace la consulta. Si user es alumno entonces (username = usernameAlumno).
$esAdmin = false;					// si la consulta la hace un admin
$esAlumno = false;					// si la consulta la hace un alumno

// #################### VERIFICAR USUARIO ####################
$queryAdmins = "SELECT username
				FROM administrador;";

$queryAlumnos = "SELECT username
				FROM alumno;";

$adminsRowArray = $dbp->query($queryAdmins)->fetchAll();
$alumnosRowArray = $dbp->query($queryAlumnos)->fetchAll();

$admins = [];
$alumnos = [];

foreach ($adminsRowArray as $admin) {
	array_push($admins, $admin[0]);
}
foreach ($alumnosRowArray as $alumno) {
	array_push($alumnos, $alumno[0]);
}

if (in_array($username, $admins)) {
	$esAdmin = true;
} elseif (in_array($username, $alumnos)) {
	$esAlumno = true;
}

// #################### AHORA A HACER MAGIA ####################
if ($esAlumno || $esAdmin) {
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
	$informacionAlumnoRowArray = $dbp->query($queryAdmins)->fetchAll();
	$cursosRowArray = $dbp->query($queryAlumnos)->fetchAll();

	// ##### Tabla información alumno #####
	echo '<table border="1" class="table">';
	echo '<tr>';
	echo "<th>RUT</th>";
	echo "<th>Usuario</th>";
	echo "<th>Nombres</th>";
	echo "<th>Apellido Paterno</th>";
	echo "<th>Apellido Materno</th>";
	echo "<th>Mail UC</th>";
	echo "<th>Año admision</th>";
	echo "<th>En causal</th>";
	echo "</tr>";
	
	foreach($informacionAlumnoRowArray as $informacionAlumno)
	{
		echo "<tr>";
		echo "<td>" . $informacionAlumno[0] . "</td>";
		echo "<td>" . $informacionAlumno[1] . "</td>";
		echo "<td>" . $informacionAlumno[2] . "</td>";
		echo "<td>" . $informacionAlumno[3] . "</td>";
		echo "<td>" . $informacionAlumno[4] . "</td>";
		echo "<td>" . $informacionAlumno[5] . "</td>";
		echo "<td>" . $informacionAlumno[6] . "</td>";
		echo "<td>" . $informacionAlumno[7] . "</td>";
		echo "</tr>";
	}
	
	echo "</table>";
	echo "<br><br>";

	// ##### Tabla información cursos del alumno #####
	echo '<table border="1" class="table">';
	echo '<tr>';
	echo "<th>NRC</th>";
	echo "<th>Sigla</th>";
	echo "<th>Seccion</th>";
	echo "<th>Nombre ramo</th>";
	echo "<th>Año</th>";
	echo "<th>Semestre</th>";
	echo "<th>Nota</th>";
	echo "</tr>";
	
	foreach($cursosRowArray as $curso)
	{
		echo "<tr>";
		echo "<td>" . $curso[0] . "</td>";
		echo "<td>" . $curso[1] . "</td>";
		echo "<td>" . $curso[2] . "</td>";
		echo "<td>" . $curso[3] . "</td>";
		echo "<td>" . $curso[4] . "</td>";
		echo "<td>" . $curso[5] . "</td>";
		echo "<td>" . $curso[6] . "</td>";
		echo "</tr>";
	}
	
	echo "</table>";
	echo "<br><br>";

}


?>


<!-- ADMIN
[SQL] Ver informacion alumno #1: Informacion personal
SELECT usuario.rut, usuario.username, usuario.nombres, usuario.apellidop, usuario.apellidom, alumno.mailuc, usuario.paisorigen, usuario.sexo, usuario.estadocivil, usuario.fnacimiento, alumno.anoadmin, alumno.encausal
FROM usuario, alumno
WHERE usuario.username = alumno.username
AND alumno.username = '{$usernameAlumno}'
AND '{$usernameAdministrador}' IN (SELECT administrador.username FROM administrador)

[SQL] Ver informacion alumno #2: Historial ramos
SELECT curso.nrc, curso.sigla, curso.seccion, ramo.nombre, curso.ano, curso.semestre, nota.notafinal
FROM nota, ramo, curso
WHERE nota.username = '{$usernameAlumno}'
AND nota.nrc = curso.nrc
AND ramo.sigla = curso.sigla
ORDER BY curso.ano, curso.semestre, curso.sigla, ramo.nombre
AND '{$usernameAdministrador}' IN (SELECT administrador.username FROM administrador)
-->

<!-- ALUMNO
Ver informacion alumno #1: Informacion personal
SELECT usuario.rut, usuario.username, usuario.nombres, usuario.apellidop, usuario.apellidom, alumno.mailuc, usuario.paisorigen, usuario.sexo, usuario.estadocivil, usuario.fnacimiento, alumno.anoadmin, alumno.encausal
FROM usuario, alumno
WHERE usuario.username = alumno.username
AND alumno.username = '{$usernameAlumno}'

Ver informacion alumno #2: Historial ramos
SELECT curso.nrc, curso.sigla, curso.seccion, ramo.nombre, curso.ano, curso.semestre, nota.notafinal
FROM nota, ramo, curso
WHERE nota.username = '{$usernameAlumno}'
AND nota.nrc = curso.nrc
AND ramo.sigla = curso.sigla
ORDER BY curso.ano, curso.semestre, curso.sigla, ramo.nombre
-->