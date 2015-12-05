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

// #################### AHORA A HACER MAGIA ####################
$queryInfoCursos = "SELECT curso.nrc, curso.sigla, curso.seccion, ramo.nombre, curso.semestre, curso.ano, ramo.escuela,
						ramo.ncreditos, curso.cupos, curso.programa
					FROM curso, ramo
					WHERE ramo.sigla = curso.sigla;";

$informacionCursosRowArray = $dbp->query($queryInfoCursos)->fetchAll();

// ##### Mostrar info curso #####
$columnas = array(
	"NRC",
	"Sigla",
	"Seccion",
	"Nombre",
	"Semestre",
	"Año",
	"Departamento",
	"Creditos",
	"Cupos",
	"Programa"
	);
imprimirTabla($columnas, $informacionCursosRowArray, 0, "informacionCurso.php");

?>