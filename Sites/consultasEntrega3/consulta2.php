<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>RENNAB</title>

</head>

<?php
	try {
		$db = new PDO("pgsql:dbname=grupo5;host=localhost;port=5432;user=grupo5;password=gruponico"); 
		}
	catch(PDOException $e) {
		echo $e->getMessage();
		}
	
	echo "<h1>Resultado Consulta 2:</h1>";
	
	$query="SELECT ramo.nombre
	FROM ramo, curso, nota
	WHERE ramo.sigla = curso.sigla
	AND curso.nrc = nota.nrc
	AND nota.notafinal >= 4.0
	AND nota.username = '" . $_POST['alumno'] . "'";
	
	echo '<table border="1">';
	echo '<tr>';
	echo "<th>Ramo</th>";
	echo "</tr>";
	
	foreach($db->query($query) as $row)
	{
		echo "<tr>";
		echo "<td>" . $row[0] . "</td>";
		echo "</tr>";
	}
	
	echo "</table>";

?>