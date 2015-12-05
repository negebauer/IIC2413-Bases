<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>RENNAB</title>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

</head>

<?php

// #################### PARA USAR INFO DE SESION ####################
session_start();

// #################### LIBRERIAS ####################
require_once('functions.php');

// #################### DECLARACION BASES DE DATOS ####################
try {
	$dbp = new PDO("pgsql:dbname=grupo5;host=localhost;port=5432;user=grupo5;password=gruponico");
}
catch(PDOException $e) {
	echo $e->getMessage();
}

// #################### VARIABLES GENERALES ####################
$username = "testuser1";			// username de quien hace la consulta
$esAdmin = false;					// si la consulta la hace un admin
$esAlumno = false;					// si la consulta la hace un alumno
$esAlumnoIntercambio = false;		// si la consulta la hace un alumno de intercambio
$esProfesor = false;				// si la consulta la hace un profesor

// #################### VARIABLES ESPECIFICAS ####################
$esProfesorCurso =false;
$

// #################### VERIFICAR USUARIO ####################
$arrayEsUsuario = verificarUsuario();
$esAdmin = $arrayEsUsuario[0];
$esProfesor = $arrayEsUsuario[3];

// #################### AHORA A HACER MAGIA ####################
if ($esProfesor)
{
	$queryProfesoresCurso = "SELECT username
							FROM profesorcurso
							WHERE "
}

if ($esProfesorCurso)
{

}
elseif ($esAdmin)
{

}

?>