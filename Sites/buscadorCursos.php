<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>RENNAB</title>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

</head>

<?php

// #################### LIBRERIAS ####################
require_once('functions.php');

// #################### VARIABLES ####################
$nombreRamo = $siglaCurso = $escuelaRamo = $nombreProfesor =$apellidoPProfesor = $apellidoMProfesor = "";

// #################### AHORA A HACER MAGIA ####################

//FUENTE: http://www.w3schools.com/php/php_form_validation.asp

$bienvenidaBuscadorCursos = array (
	"<h2>Buscador de Cursos</h2>",
	"<form method='post' action='buscadorCursos.php'>",
		"<p>$emsp;$emsp; Año: <input type='number' name='anoCurso' value=2015></p>",
		"<p>$emsp;$emsp; Semestre: <input type='number' name='semestreCurso' value=2></p>",
		"<p>$emsp;$emsp; Nombre del Ramo: <input type='text' name='nombreRamo'></p>",
		"<p>$emsp;$emsp; Sigla: <input type='text' name='siglaCurso'></p>",
		"<p>$emsp;$emsp; Escuela: <input type='text' name='escuelaRamo'></p>",
		"<p>$emsp;$emsp; Nombre del Profesor: <input type='text' name='nombreProfesor'></p>",
		"<p>$emsp;$emsp; Apellido Paterno del Profesor: <input type='text' name='apellidoPProfesor'></p>",
		"<p>$emsp;$emsp; Apellido Materno del Profesor: <input type='text' name='apellidoMProfesor'></p>",
		"<input type='submit' name='submit' value='Buscar'> ",
	"</form>"
	);

imprimirLineas($bienvenidaBuscadorCursos);

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
   $nombreRamo = $_POST["nombreRamo"];
   $siglaCurso = $_POST["siglaCurso"];
   $escuelaRamo = $_POST["escuelaRamo"];
   $nombreProfesor = $_POST["nombreProfesor"];
   $apellidoPProfesor = $_POST["apellidoPProfesor"];
   $apellidoMProfesor = $_POST["apellidoMProfesor"];
   $semestreCurso = $_POST["semestreCurso"];
   $anoCurso = $_POST["anoCurso"];

	$ultimaBusqueda = array (
		"<h2>Tu última búsqueda:</h2>",
		"<p>&emsp;&emsp; Año: $anoCurso</p>",
		"<p>&emsp;&emsp; Semestre: $semestreCurso</p>",
		"<p>&emsp;&emsp; Nombre ramo: $nombreRamo</p>",
		"<p>&emsp;&emsp; Sigla curso: $siglaCurso</p>",
		"<p>&emsp;&emsp; Escuela ramo: $escuelaRamo</p>",
		"<p>&emsp;&emsp; Nombre Profesor: $nombreProfesor</p>",
		"<p>&emsp;&emsp; Apellido Paterno profesor: $apellidoPProfesor</p>",
		"<p>&emsp;&emsp; Apellido Materno profesor: $apellidoMProfesor</p>"
	);
	
	imprimirLineas($ultimaBusqueda);
	
	// Nuestras Consultas
	$queryBuscadorCursos = "SELECT curso.nrc, ramo.nombre, curso.sigla, curso.seccion, curso.semestre, curso.ano, ramo.escuela, ramo.ncreditos, curso.cupos
							FROM curso, ramo
							WHERE ramo.sigla = curso.sigla
							AND ramo.nombre LIKE CONCAT('{$nombreRamo}', '%')
							AND curso.sigla LIKE CONCAT('{$siglaCurso}', '%')
							AND curso.semestre = {$semestreCurso}
							AND curso.ano = {$anoCurso}
							AND ramo.escuela LIKE CONCAT('{$escuelaRamo}', '%')
							AND (curso.sigla, curso.nrc) IN (SELECT curso.sigla, curso.nrc
															FROM curso, profesorcurso, usuario
															WHERE curso.nrc = profesorcurso.nrc
															AND profesorcurso.username = usuario.username
															AND (usuario.nombres LIKE CONCAT('%', '{$nombreProfesor}', '%'))
																AND usuario.apellidop LIKE CONCAT('%', '{$apellidoPProfesor}', '%')
																AND usuario.apellidom LIKE CONCAT('%', '{$apellidoMProfesor}', '%')
															)
							ORDER BY curso.sigla, ramo.nombre;";
		
	// ##### Hacemos las consultas #####
	$infoBuscadorCursosRowArray = $dbp->query($queryBuscadorCursos)->fetchAll();
	
	// ##### Tabla información curso #####
	$columnas = array (
		"NRC",
		"Curso",
		"Sigla",
		"Sección",
		"Semestre",
		"Año",
		"Escuela",
		"Créditos",
		"Cupos"
		);
	imprimirTabla($columnas, $infoBuscadorCursosRowArray);
}

?>