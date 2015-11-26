<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>RENNAB</title>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">


</head>

<?php
	try {
		$db = new PDO("pgsql:dbname=grupo5;host=localhost;port=5432;user=grupo5;password=gruponico"); 
		}
	catch(PDOException $e) {
		echo $e->getMessage();
		}
	
	echo "<h1>Resultado Consulta 3:</h1>";
	
	$query="SELECT COUNT(alumno.username)
	FROM nota, alumno, requisito, ramo, curso
	WHERE nota.username = alumno.username
	AND nota.notafinal >= 4.0
	AND curso.sigla = ramo.sigla
	AND nota.nrc = curso.nrc
	AND requisito.siglarequisito = curso.sigla
	AND requisito.siglaramo = '" . $_POST['sigla'] . "'";
	
	echo '<table border="1" class="table">';
	echo '<tr>';
	echo "<th>Cantidad</th>";
	echo "</tr>";
	
	foreach($db->query($query) as $row)
	{
		echo "<tr>";
		echo "<td>" . $row[0] . "</td>";
		echo "</tr>";
	}
	
	echo "</table>";

?>