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
$nrcCurso = intval($_POST['nrcCurso']);

// #################### VERIFICAR USUARIO ####################
$arrayEsUsuario = verificarUsuario($username);
$esAdmin = $arrayEsUsuario[0];
$esAlumno = $arrayEsUsuario[1];
$esProfesor = $arrayEsUsuario[3];

// #################### AHORA A HACER MAGIA ####################
$queryInfoCurso = "SELECT curso.nrc, curso.sigla, curso.seccion, ramo.nombre, curso.semestre, curso.ano, ramo.escuela,
						ramo.ncreditos, curso.cupos, curso.programa
					FROM curso, ramo
					WHERE ramo.sigla = curso.sigla
					AND curso.nrc = $nrcCurso;";

$queryProfesoresCurso = "SELECT nombres, apellidop, apellidom, mailuc, departamento, facultad
					FROM usuario, profesor, profesorcurso
					WHERE usuario.username = profesor.username
					AND profesor.username = profesorcurso.username
					AND profesorcurso.nrc = $nrcCurso;";

$informacionCursoRowArray = $dbp->query($queryInfoCurso)->fetchAll();
$profesoresCursoRowArray = $dbp->query($queryProfesoresCurso)->fetchAll();

// ##### Mostrar info curso #####
$columnas = array(
	"NRC",
	"Sigla",
	"Seccion",
	"Nombre",
	"Semestre",
	"Año",
	"Escuela",
	"Creditos",
	"Cupos",
	"Programa"
	);
imprimirTabla($columnas, $informacionCursoRowArray, 9, "PROGRAMURL");

// ##### Mostrat info profesores curso #####
$columnas = array(
	"Nombre",
	"Apellido Paterno",
	"Apellido Materno",
	"Mail UC",
	"Departamento",
	"Facultad"
	);
imprimirTabla($columnas, $profesoresCursoRowArray);

// ##### Veamos si es profesor del curso (para poder cambiar notas) #####
if ($esProfesor)
{
	// ##### Declaramos consulta para ver si es profesor del ramo #####
	$queryProfesoresCurso = "SELECT username
							FROM profesorcurso
							WHERE nrc = $nrcCurso;";

	// ##### Ejecutamos la consulta #####
	$profesoresCursoRowArray = $dbp->query($queryProfesoresCurso)->fetchAll();
	
	$profesoresCurso = [];
		
	foreach ($profesoresCursoRowArray as $profesorCurso)
	{
		array_push($admins, $profesorCurso[0]);
	}

	// ##### Vemos si es profe del curso #####
	if (in_array($username, $profesoresCurso))
	{
		$esProfesorCurso = true;
	}
}

if ($esProfesorCurso)
{
	echo "Es profesorcurso<br>";
	// ##### Declaramos consulta para ver informacion del curso #####
}
elseif ($esAdmin)
{
	echo "Es admin<br>";
}

?>