<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>RENNAB</title>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

</head>

<?php

// #################### LIBRERIAS ####################
require_once('functions.php');

// #################### VARIABLES ####################
$esProfesorCurso =false;
$nrcCurso = intval($_POST['nrcCurso']);

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
		array_push($profesoresCurso, $profesorCurso[0]);
	}

	// ##### Vemos si es profe del curso #####
	if (in_array($username, $profesoresCurso))
	{
		$esProfesorCurso = true;
	}
}

if ($esProfesorCurso)
{
	// ##### Declaramos consulta para ver alumnos del curso #####
	$queryAlumnosCurso = "SELECT usuario.username, usuario.nombres, usuario.apellidop, usuario.apellidom, alumno.mailuc, nota.notafinal
						FROM usuario, alumno, nota
						WHERE usuario.username = alumno.username
						AND nota.username = alumno.username
						AND nota.nrc = {$nrcCurso};";

	// ##### Ejecutamos la consulta #####
	$alumnosCursoRowArray = $dbp->query($queryAlumnosCurso)->fetchAll();

	echo "<form action='informacioCurso.php' method='post'>";

	// ##### Mostrar info alumnos curso #####
	$columnas = array(
		"Usuario",
		"Nombres",
		"Apellido Paterno",
		"Apellido Materno",
		"Mail UC",
		"Nota final",
		"Nueva nota"
	);

	$alumnosCursoRowArrayConFormNota = [];
	foreach ($alumnosCursoRowArray as $alumnoRow)
	{
		$modificacionNota = "<input name=$alumnoRow[0]>";
		$nuevaRow = array_merge($alumnoRow, $modificacionNota);
		array_push($alumnosCursoRowArrayConFormNota, $nuevaRow);
	}

	imprimirTabla($columnas, $alumnosCursoRowArrayConFormNota);

	echo "</form>";
}
elseif ($esAdmin)
{
	// ##### Declaramos consulta para ver alumnos del curso #####
	$queryAlumnosCurso = "SELECT usuario.username, usuario.nombres, usuario.apellidop, usuario.apellidom, alumno.mailuc, nota.notafinal
						FROM usuario, alumno, nota
						WHERE usuario.username = alumno.username
						AND nota.username = alumno.username
						AND nota.nrc = {$nrcCurso};";

	// ##### Ejecutamos la consulta #####
	$alumnosCursoRowArray = $dbp->query($queryAlumnosCurso)->fetchAll();

	// ##### Mostrar info alumnos curso #####
	$columnas = array(
		"Usuario",
		"Nombres",
		"Apellido Paterno",
		"Apellido Materno",
		"Mail UC",
		"Nota final"
		);
	imprimirTabla($columnas, $alumnosCursoRowArray);
}

?>