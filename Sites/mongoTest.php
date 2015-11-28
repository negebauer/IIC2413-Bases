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
foreach($alumnos->find() as $alumno)
	{
		echo "<tr>";
		echo "<td>" . $alumnos.findOne() . "</td>";
		echo "</tr>";
	}
echo "<br>";
foreach($cursos->find() as $curso)
	{
		echo "<tr>";
		echo "<td>" . $cursos.findOne() . "</td>";
		echo "</tr>";
	}
echo "<br>";
foreach($universidades->find() as $universidad)
	{
		echo "<tr>";
		echo "<td>" . $universidades.findOne() . "</td>";
		echo "</tr>";
	}
echo "<br>";

?>