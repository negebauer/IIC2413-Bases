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

// #################### VARIABLES ####################
$username = "testuser1";			// username de quien hace la consulta
$usernameAlumno = "testuser1";		// username del alumno sobre el cual se hace la consulta. Si user es alumno entonces (username = usernameAlumno).
$esAdmin = false;					// si la consulta la hace un admin
$esAlumno = false;					// si la consulta la hace un alumno
$esAlumnoIntercambio = false;		// si la consulta la hace un alumno de intercambio
$esProfesor = false;				// si la consulta la hace un profesor


// #################### VERIFICAR USUARIO ####################
$arrayEsUsuario = verificarUsuario();
$esAdmin = $arrayEsUsuario[0];
$esAlumno = $arrayEsUsuario[1];
$esAlumnoIntercambio = $arrayEsUsuario[2];
$esProfesor = $arrayEsUsuario[3];

?>