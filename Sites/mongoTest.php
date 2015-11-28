<?php

echo "<h3>Connecting</h3>";
echo "<br>";
echo $dbhost = "localhost";
echo "<br>";
echo $dbname = "test";
echo "<br>";
echo $mongo = new MongoClient("mongodb://$dbhost");
echo "<br>";
echo "<h3>Setting database reference</h3>";
echo "<br>";
echo $db = $mongo->$dbname;
echo "<h3>Setting collections references</h3>";
echo "<br>";
echo $db = $mongo->$dbname;
echo "<br>";
echo $alumnos = $db->alumnos;
echo "<br>";
echo $cursos = $db->cursos;
echo "<br>";
echo $universidades = $db->universidades;
echo "<br>";

$alumno1 = $db->alumnos->findOne();
var_dump($alumno1);
var_dump($alumno1["cursos"]);
$cursosAlumno1 = $cursos->find(array('_id' => array('$in' => $alumno1["cursos"])));
echo "<br><br>";
echo "Found {$cursosAlumno1->count()}";
echo "<br>";
var_dump(iterator_to_array($cursosAlumno1));

echo "<br><br>";
echo "<h3>Mostremos los nombres los cursos que ha hecho un alumno</h3>";
$alumno1 = $alumnos->findOne();
$cursosAlumno1 = $alumno1["cursos"];
foreach (iterator_to_array($cursos->find()) as $curso)
{
	if (in_array($curso["_id"], $alumno1["cursos"])) {
    	echo "(id) {$alumno1["_id"]} (Alumno) {$alumno1["nombre"]} realizo (curso) {$curso["nombre"]} <br>";
	}
}

echo "<br><br>";
echo "<h3>Mostremos la universidad de un alumno</h3>";
$alumno1 = $alumnos->findOne();
foreach (iterator_to_array($universidades->find()) as $universidad)
{
	if ($universidad["_id"] == $alumno1["universidad"]) {
    	echo "(Alumno) {$alumno1["nombre"]} viene de (universidad) {$universidad["nombre"]} <br>";
	}
}

echo "<h3>Showing stuff</h3>";
echo "<br>";
var_dump($alumnos->find()->limit(2));
echo "<br>";
echo $alumnos->find()->count();
echo "<br>";
var_dump($cursos->find()->limit(2));
echo "<br>";
echo $cursos->find()->count();
echo "<br>";
var_dump($universidades->find()->limit(2));
echo "<br>";
echo $universidades->find()->count();
echo "<br>";

echo "<br><br>";
echo "<h3>Mostremos los nombres de todos los alumnos</h3>";
foreach (iterator_to_array($alumnos->find()) as $alumno)
{
	$nombreRaw = $alumno["nombre"];
	$splited = explode(" ", $nombreRaw);
	$nombre = $splited[0];
	$apellido = $splited[1];
	echo "Alumno {$nombreRaw}<br>&emsp;Nombre: {$nombre}<br>&emsp;Apellido: {$apellido}<br>";
	if (count($splited) > 2) {
		echo "&emsp--- HAY UNO QUE TIENE MAS DE DOS COSAS: {$nombreRaw}";
	}
}

?>