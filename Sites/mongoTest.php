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

$alumno1 = $db->alumnos->findOne();
var_dump($alumno1);
var_dump($alumno1["cursos"]);
$cursosAlumno1 = $cursos->find(array('_id' => array('$in' => $alumno1["cursos"])));
echo "<br><br><br>";
echo "Found {$cursosAlumno1->count()}";
echo "<br>";
var_dump(iterator_to_array($cursosAlumno1));

?>