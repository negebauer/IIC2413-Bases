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
			(username, password, direccion, mail, nombres, apellidop)
			VALUES ('{$id}', 1234, '{$direccion}', '{$email}', '{$nombre}', '{$apellido}');
			INSERT INTO alumno
			(username, mailuc, anoadmin)
			VALUES ();
			INSERT INTO alumnointercambio
			VALUES ('{$id}', '{$universidad}');";

	// Agregamos el alumno a la base de datos
	$dbp->query($query);
	
}

// #################### AGREGAR CURSOS EQUIVALENTES A LA BASE DE DATOS CON NOMBRE EXTRANJERO ####################

?>