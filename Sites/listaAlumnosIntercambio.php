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

if ($esAdmin){

	$alumnos = $dbm->alumnos;
	$universidades = $dbm->universidades;

	$columnas = array(
		"Usuario",
		"Nombre",
		"Apellido",
		"Universidad"
		);

	$datos = array();

	foreach (iterator_to_array($alumnos->find()) as $alumno)
	{
		$splited = explode(" ", $alumno["nombre"]);
		foreach (iterator_to_array($universidades->find()) as $universidad)
		{
			if ($universidad["_id"] == $alumno["universidad"]) {
		    	$universidadAlumno = $universidad["nombre"];
		    	break;
			}
		}
		array_push($datos, array(
			$alumno["_id"],
			$splited[0],
			$splited[1],
			$universidadAlumno
			));
	}

	imprimirTabla($columnas, $datos, 0, "informacionAlumnoIntercambio.php", 'usernameAlumno');
}
?>