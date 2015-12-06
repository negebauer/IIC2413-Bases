<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>RENNAB</title>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

</head>

<?php

// #################### LIBRERIAS ####################
require_once('functions.php');

// #################### VARIABLES ####################


// #################### AHORA A HACER MAGIA ####################
if ($username == "")
{
	header("location:login.php");
}

echo "<p>Usuario actualmente conectado: $username</p>";
echo "<a href='logout.php'>Logout</a><br>";

if ($esAdmin)
{
	echo "<br><p>Usuario actual es <b>admin</b></p>";
	$vistasAdmin = array(
		"<form action='listaCursos.php'>",
    		"<input type='submit' value='Lista cursos'>",
		"</form>",
		"<form action='buscadorCursos.php'>",
    		"<input type='submit' value='Buscador cursos'>",
		"</form>",
		"<form action='listaAlumnos.php'>",
    		"<input type='submit' value='Lista alumnos'>",
		"</form>",
		"<form action='listaAlumnosIntercambio.php'>",
    		"<input type='submit' value='Lista alumnos intercambio'>",
		"</form>",
		"<form action='crearCurso.php'>",
    		"<input type='submit' value='Crear curso'>",
		"</form>",
		"<form action='eliminarCurso.php'>",
    		"<input type='submit' value='Eliminar curso'>",
		"</form>"
	);
	imprimirLineas($vistasAdmin);
}

if ($esAlumno)
{
	echo "<br><p>Usuario actual es <b>alumno</b></p>";
	$vistasAlumno = array(
		"<form action='listaCursos.php'>",
    		"<input type='submit' value='Lista cursos'>",
		"</form>",
		"<form action='buscadorCursos.php'>",
    		"<input type='submit' value='Buscador cursos'>",
		"</form>",
		"<form action='informacionAlumno.php'>",
    		"<input type='submit' value='Informacion alumno'>",
		"</form>",
		"<form action='inscribirCurso.php'>",
    		"<input type='submit' value='Inscribir curso'>",
		"</form>"
	);
	imprimirLineas($vistasAlumno);
}

if ($esAlumnoIntercambio)
{
	echo "<br><p>Usuario actual es <b>alumno intercambio</b></p>";
	$vistasAlumnoIntercambio = array(
		"<form action='informacionAlumnoIntercambio.php'>",
    		"<input type='submit' value='Informacion alumno intercambio'>",
		"</form>"
	);
	imprimirLineas($vistasAlumnoIntercambio);
}

if ($esProfesor)
{
	echo "<br><p>Usuario actual es <b>profesor</b></p>";
	$vistasProfesor = array(
		"<form action='listaCursos.php'>",
    		"<input type='submit' value='Lista cursos'>",
		"</form>",
		"<form action='buscadorCursos.php'>",
    		"<input type='submit' value='Buscador cursos'>",
		"</form>",
		"<form action='listaAlumnos.php'>",
    		"<input type='submit' value='Lista alumnos'>",
		"</form>"
	);
	imprimirLineas($vistasProfesor);
}

?>