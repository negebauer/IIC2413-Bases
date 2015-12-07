<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>RENNAB</title>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

</head>

<?php

// #################### LIBRERIAS ####################
require_once('functions.php');

// #################### VARIABLES PREDECLARADAS ####################
// Son las que puedes usar gracias a la libreria functions.php que importa global.php
// $dbm 					La base de datos de mongo
// $dbp 					La base de datos de psql
// $username 				Username de quien hace la consulta
// $arrayEsUsuario 			Verifica quien hace consulta
// $esAdmin 				Si la consulta la hace un admin
// $esAlumno 				Si la consulta la hace un alumno
// $esAlumnoIntercambio 	Si la consulta la hace un alumno de intercambio
// $esProfesor 				Si la consulta la hace un profesor

// #################### FUNCIONES ####################
// imprimirLineas($lineas)																Imprime varias lineas (echo)
// imprimirTabla($columnas, $data, $indexURL = -1, $url = "", $postVarName = "")		Imprime una tabla con columnas y datos de un query
// 			Ademas permite que uno de los lugares de la tabla sea un boton que linke a $url. La columna sera la definida por $indexURL
// 			y el nombre de la variables que se enviara en POST sera $posstVarName

// #################### VARIABLES ####################


// #################### AHORA A HACER MAGIA ####################
if ($esAdmin)
{
	$formularioEliminarCurso = array(
		"<form action='eliminarCurso.php' method='post'>",
			"<select name=nrcCurso>"
	);

	$cierreFormulario = array(
			"</select>",
			"<input type='submit' name='submit' value='Eliminar curso'>",
		"</form>"
	);

	$queryCursos = "SELECT curso.nrc, curso.sigla, curso.seccion, ramo.nombre, curso.semestre, curso.ano
					FROM curso, ramo
					WHERE ramo.sigla = curso.sigla
					ORDER BY curso.ano DESC, curso.semestre DESC, curso.sigla ASC, curso.seccion ASC, ramo.nombre ASC;";

	$cursosRowArray = $dbp->query($queryCursos)->fetchAll();

	foreach ($cursosRowArray as $cursoRow) {
		$cursoNRC = $cursoRow[0];
		$cursoSigla = $cursoRow[1];
		$cursoSeccion = $cursoRow[2];
		$cursoNombre = $cursoRow[3];
		$cursoSemestre = $cursoRow[4];
		$cursoAno = $cursoRow[5];
		$cursoInfo = $cursoNRC . " " . $cursoSigla . " " . $cursoSeccion . " " . $cursoNombre . " " . $cursoSemestre . " " . $cursoAno;
		$option = "<option value=$cursoNRC>$cursoInfo</option>";
		array_push($formularioEliminarCurso, $option);
	}

	$formularioEliminarCurso = array_merge($formularioEliminarCurso, $cierreFormulario);

	imprimirLineas($formularioEliminarCurso);

	$nrcCursoEliminado = isset($_POST['usernameProfesor']) ? $_POST['usernameProfesor'] : "";

	if ($nrcCursoEliminado != "")
	{
		$queryEliminarCurso = "DELETE
						FROM curso
						WHERE nrc = $nrcCurso;";

		$dbp->query($queryEliminarCurso);

		$queryCursoExiste = "SELECT COUNT(*)
						FROM curso
						WHERE nrc = $nrcCurso";

		$curso = $dbp->query($queryCursoExiste)->fetchAll();
		if ($curso[0][0] > 0)
		{
			echo "Curso eliminado correctamente";
		}
		else
		{
			echo "Curso no fue eliminado";
		}
	}
	
}


?>