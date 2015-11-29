<?php

try {
		$dbpsql = new PDO("pgsql:dbname=grupo5;host=localhost;port=5432;user=grupo5;password=gruponico"); 
	}
catch(PDOException $e) {
	echo $e->getMessage();
	}

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

echo "<h3>Mostremos los nombres los cursos que ha hecho un alumno</h3>";
$alumno1 = $alumnos->findOne();
$cursosAlumno1 = $alumno1["cursos"];
foreach (iterator_to_array($cursos->find()) as $curso)
{
	if (in_array($curso["_id"], $alumno1["cursos"])) {
    	echo "(id) {$alumno1["_id"]} (Alumno) {$alumno1["nombre"]} realizo (curso) {$curso["nombre"]} <br>";
	}
}

echo "<h3>Mostremos la universidad de un alumno</h3>";
$alumno1 = $alumnos->findOne();
foreach (iterator_to_array($universidades->find()) as $universidad)
{
	if ($universidad["_id"] == $alumno1["universidad"]) {
    	echo "(Alumno) {$alumno1["nombre"]} viene de (universidad) {$universidad["nombre"]} <br>";
	}
}

echo "<h3>Buscar un alumno en particular</h3>";
$id = "563c1a99a20c8c06c7918b3f";
$mongoid = new MongoId($id);
$idQuery = array("_id" => $mongoid);
$alumnosMatch = $alumnos->find($idQuery);
$alumnosMatch->next();
$alumno1 = $alumnosMatch->current();
echo "Alumno encontrado: (id) {$alumno1["_id"]} (nombre) {$alumno1["nombre"]}";
echo "<br>";

echo "<h3>Showing stuff</h3>";
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

echo "<h3>Unos conteos</h3>";
$cursosAfuera = 0;
$cursosEquivalentes = 0;
foreach (iterator_to_array($cursos->find()) as $curso)
{
	$nombre = $curso["nombre"];
	$equivalencia = $curso["equivalencia"];
	$cursosAfuera += 1;
	$query = "SELECT sigla, nombre
			FROM ramo
			WHERE ramo.sigla = '{$equivalencia}';";
	$queryResult = $dbpsql->query($query);
	$notFound = true;
	foreach($queryResult as $row)
	{
		if ($notFound) {
			$cursosEquivalentes += 1;
		}
		$notFound = false;
	}
}
echo "Numero de cursos de el exterior: {$cursosAfuera}<br>";
echo "Numero de cursos de equivalentes locales: {$cursosEquivalentes}<br>";

echo "<h3>Mostremos todos los cursos</h3>";
foreach (iterator_to_array($cursos->find()) as $curso)
{
	$nombre = $curso["nombre"];
	$equivalencia = $curso["equivalencia"];
	echo "Curso: (equivalencia) {$equivalencia} (nombre) {$nombre}<br>";
	$query = "SELECT sigla, nombre
			FROM ramo
			WHERE ramo.sigla = '{$equivalencia}';";
	$queryResult = $dbpsql->query($query);
	$notFound = true;
	foreach($queryResult as $row)
	{
		echo "&emsp;Local: (sigla) {$row[0]} (nombre) {$row[1]}<br>";
		$notFound = false;
	}
	if ($notFound) {
		echo "&emsp;No esta local<br>";
	}
}

echo "<h3>Mostremos los equivalentes (siglas) de todos los cursos</h3>";
foreach (iterator_to_array($cursos->find()) as $curso)
{
	$nombre = $curso["nombre"];
	$equivalencia = $curso["equivalencia"];
	// echo "Curso: (equivalencia) {$equivalencia} (nombre) {$nombre}<br>";
	$query = "SELECT sigla, nombre
			FROM ramo
			WHERE ramo.sigla = '{$equivalencia}';";
	$queryResult = $dbpsql->query($query);
	$notFound = true;
	foreach($queryResult as $row)
	{
		//echo "&emsp;Local: (sigla) {$row[0]} (nombre) {$row[1]}<br>";
		echo "{$row[0]}: {$row[1]}<br>";
		$notFound = false;
	}
	if ($notFound) {
		//echo "&emsp;No esta local<br>";
	}
}

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