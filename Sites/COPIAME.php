<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>RENNAB</title>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

</head>

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
$esAlumnoIntercambio = false;		// si la consulta la hace un alumno de intercambio
$esProfesor = false;				// si la consulta la hace un profesor


// #################### VERIFICAR USUARIO ####################
$queryAdmins = "SELECT username
				FROM administrador;";

$queryAlumnos = "SELECT username
				FROM alumno;";

$queryAlumnosIntercambio = "SELECT username
							FROM alumnointercambio;";

$queryProfesores = "SELECT username
					FROM profesor;";

$adminsRowArray = $dbp->query($queryAdmins)->fetchAll();
$alumnosRowArray = $dbp->query($queryAlumnos)->fetchAll();
$alumnosIntercambioRowArray = $dbp->query($queryAlumnosIntercambio)->fetchAll();
$profesoresRowArray = $dbp->query($queryProfesores)->fetchAll();

$admins = [];
$alumnos = [];
$alumnosIntercambio = [];
$profesores = [];

foreach ($adminsRowArray as $admin) {
	array_push($admins, $admin[0]);
}
foreach ($alumnosRowArray as $alumno) {
	array_push($alumnos, $alumno[0]);
}
foreach ($alumnosIntercambioRowArray as $alumnoIntercambio) {
	array_push($alumnosIntercambio, $alumnoIntercambio[0]);
}
foreach ($profesoresRowArray as $profesor) {
	array_push($profesores, $profesor[0]);
}

if (in_array($username, $admins)) {
	$esAdmin = true;
} elseif (in_array($username, $alumnos)) {
	$esAlumno = true;
} elseif (in_array($username, $alumnosIntercambio)) {
	$esAlumnoIntercambio = true;
} elseif (in_array($username, $profesores)) {
	$esProfesor = true;
}

?>