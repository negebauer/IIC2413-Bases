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

$admins = $dbp->query($queryAdmins)->fetchAll();
$alumnos = $dbp->query($queryAlumnos)->fetchAll();

if (in_array($username, $admins)) {
	$esAdmin = true;
} elseif (in_array($username, $alumnos)) {
	$esAlumno = true;
}

echo "Es alumno: {$esAlumno}";
echo "Es admin: {$esAdmin}";

// #################### AHORA A HACER MAGIA ####################

if (esAlumno || esAdmin) {
	// Declaramos las consultas
	$queryInfoAlumno = "SELECT usuario.rut, usuario.username, usuario.nombres, usuario.apellidop, usuario.apellidom, alumno.mailuc, usuario.paisorigen,
							usuario.sexo, usuario.estadocivil, usuario.fnacimiento, alumno.anoadmin, alumno.encausal 
						FROM usuario, alumno
						WHERE usuario.username = alumno.username
						AND alumno.username = '{$usernameAlumno}';";
	
	$queryCursosAlumno = "SELECT curso.nrc, curso.sigla, curso.seccion, ramo.nombre, curso.ano, curso.semestre, nota.notafinal
						FROM nota, ramo, curso
						WHERE nota.username = '{$usernameAlumno}'
						AND nota.nrc = curso.nrc
						AND ramo.sigla = curso.sigla
						ORDER BY curso.ano, curso.semestre, curso.sigla, ramo.nombre;";
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