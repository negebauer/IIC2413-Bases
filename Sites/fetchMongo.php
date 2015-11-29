<?php

// #################### DELCARACION BASES DE DATOS ####################
$dbhost = "localhost";
$dbname = "test";
$mongo = new MongoClient("mongodb://$dbhost");
$dbm = $mongo->$dbname;

try {
	$dbp = new PDO("pgsql:dbname=grupo5;host=localhost;port=5432;user=grupo5;password=gruponico");
}
catch(PDOException $e) {
	echo $e->getMessage();
}

// #################### AGREGAR ALUMNOS DE INTERCAMBIO A BASE DE DATOS ####################
$alumnos = $dbm->alumnos->find();
foreach (iterator_to_array($alumnos) as $alumno)
{
	// Sacamos la info del alumno
	$nombreRaw = $alumno["nombre"];
	$splited = explode(" ", $nombreRaw);
	$nombre = $splited[0];
	$apellido = $splited[1];
	$email = $alumno["email"];
	$universidad = $alumno["universidad"];
	$direccion = $alumno["direccion"];
	$id = $alumno["_id"];

	// Nos preparamos para agregar al alumno a nuestra base de datos
	$query = "INSERT INTO usuario
			VALUES ('{$id}', 1234, '{$direccion}', '{$email}', '', '', '', '{$nombre}', '{$apellido}', '', 0, null);
			INSERT INTO alumno
			VALUES ('{$id}', '', 0, 2015, false);
			INSERT INTO alumnointercambio
			VALUES ('{$id}', '{$universidad}');";

	// Agregamos el alumno a la base de datos
	// echo "Query1: {$query1}<br>";
	// echo "Query2: {$query2}<br>";
	// echo "Query3: {$query3}<br>";
	// echo "<br>";
	$dbp->query($$query);

}

// #################### AGREGAR CURSOS EQUIVALENTES A LA BASE DE DATOS CON NOMBRE EXTRANJERO ####################
$cursos = $dbm->cursos->find();
foreach (iterator_to_array($cursos) as $curso)
{
	$sigla = $curso["sigla"];
	$nombre = $curso["nombre"];
	$query = "INSERT INTO ramo
			VALUES ('{$sigla}', '{$nombre}', 10, 'EscuelaNoIdentificada');";
	$dbp->query($query);
}

?>