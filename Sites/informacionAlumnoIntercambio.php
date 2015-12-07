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

// #################### AHORA A HACER MAGIA ####################

$id = $_POST["usernameAlumno"];
$alumnos = $dbm->alumnos;
$universidades = $dbm->universidades;
$cursos = $dbm->cursos;

$mongoid = new MongoId($id);
$idQuery = array("_id" => $mongoid);
$alumnosMatch = $alumnos->find($idQuery);
$alumnosMatch->next();
$alumno = $alumnosMatch->current();

$columnas = array(
	"Nombre",
	"Apellido",
	"Mail",
	"Universidad"
	);

foreach (iterator_to_array($universidades->find()) as $universidad)
{
	if ($universidad["_id"] == $alumno["universidad"]) {
    	$universidadAlumno = $universidad["nombre"];
    	break;
	}
}
$splited = explode(" ", $alumno["nombre"]);
imprimirTabla($columnas, array(array(
										$splited[0],
										$splited[1],
										$alumno["email"],
										$universidadAlumno
										)));

$columnasCursos = array(
	"Curso aprobado",
	"Curso UC equivalente");

$aprobados = array();

foreach (iterator_to_array($cursos->find()) as $curso)
{
	array_push($aprobados, array(
		"_id" => $curso["_id"],
		"nombre" => $curso["nombre"],
		"equivalencia" => $curso["equivalencia"]
		));
}

// foreach ($aprobados as $curso)
// {
// 	if ($aprobado["_id"] == $curso["_id"])
// 	{
// 		$nombre = $curso["nombre"];
// 		$equivalencia = $curso["equivalencia"];
// 		$query = "SELECT sigla, nombre
// 				FROM ramo
// 				WHERE ramo.sigla = '{$equivalencia}'
// 				AND ramo.nombre <> '{$nombre}'
// 				AND ramo.escuela <> 'EscuelaNoIdentificada';";
// 		$queryResult = $dbpsql->query($query);
// 		$notFound = true;
// 		foreach($queryResult as $row)
// 		{
// 			array_push($aprobados, array(
// 				$aprobado["nombre"],
// 				$curso["nombre"]
// 				));
// 			$notFound = false;
// 		}
// 		if ($notFound) {
// 			array_push($aprobados, array(
// 				$aprobado["nombre"],
// 				"No existe"
// 				));
// 		}
// 	}
// }

// imprimirTabla($columnasCursos, $aprobados);

?>