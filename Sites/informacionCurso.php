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
	// ##### Primero veamos si hay notas que actualizar #####
	$actualizarNotas = isset($_POST['actualizarNotas']) ? $_POST['actualizarNotas'] : 0;

	if ($actualizarNotas == 1)
	{
		$cantidadAlumnos = $_POST["cantidadAlumnos"];
		for ($i=0; $i < $cantidadAlumnos; $i++)
		{ 
			$identificadorNota = "nota" . $i;
			$indentificadorAlumno = "alumno" . $i;
			$usernameAlumno = $_POST[$indentificadorAlumno];
			$notaAlumno = isset($_POST[$identificadorNota]) ? $_POST[$identificadorNota] : -1;
			if ($notaAlumno != -1)
			{
				$queryActualizarNota = "UPDATE nota
										SET notafinal = $notaAlumno
										WHERE username = $usernameAlumno;";

				$dbp->query($queryActualizarNota);
			}
		}
	}

	// ##### Declaramos consulta para ver alumnos del curso #####
	$queryAlumnosCurso = "SELECT usuario.username, usuario.nombres, usuario.apellidop, usuario.apellidom, alumno.mailuc, nota.notafinal
						FROM usuario, alumno, nota
						WHERE usuario.username = alumno.username
						AND nota.username = alumno.username
						AND nota.nrc = {$nrcCurso};";

	// ##### Ejecutamos la consulta #####
	$alumnosCursoRowArray = $dbp->query($queryAlumnosCurso)->fetchAll();

	$cantidadAlumnos = count($alumnosCursoRowArray);
	echo "<form action='informacionCurso.php' method='post'>";
	echo "<input class=hidden type=number name=actualizarNotas value=1>";
	echo "<input class=hidden type=number name=cantidadAlumnos value=$cantidadAlumnos";

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
	for ($i=0; $i < $cantidadAlumnos; $i++)
	{
		$alumnoRow = $alumnosCursoRowArray[$i];
		$identificadorNota = "nota" . $i;
		$indentificadorAlumno = "alumno" . $i;
		$modificacionNota = array(
			"<input type='number' name=$identificadorNota step='0.1'>",
			"<input type='text' class='hidden' name=$indentificadorAlumno value=$alumnoRow[0]>"
		);
		$nuevaRow = array_merge($alumnoRow, $modificacionNota);
		array_push($alumnosCursoRowArrayConFormNota, $nuevaRow);
	}

	imprimirTabla($columnas, $alumnosCursoRowArrayConFormNota);

	echo "<input type='submit' name='submit' value='Actualizar notas'>";
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