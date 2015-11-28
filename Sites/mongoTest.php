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
foreach($alumnos->findOne() as $alumno)
	{
		echo "<tr>";
		echo "<td>" . $alumno . "</td>";
		echo "</tr>";
	}
echo "<br>";
foreach($cursos->findOne() as $curso)
	{
		echo "<tr>";
		echo "<td>" . $curso . "</td>";
		echo "</tr>";
	}
echo "<br>";
foreach($universidades->findOne() as $universidad)
	{
		echo "<tr>";
		echo "<td>" . $universidad . "</td>";
		echo "</tr>";
	}
echo "<br>";

?>