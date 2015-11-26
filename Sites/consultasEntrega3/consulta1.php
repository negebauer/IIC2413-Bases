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
	
	echo "<h1>Resultado Consulta 1:</h1>";
	
	$query="SELECT usuario.nombres, usuario.apellidop, usuario.apellidom, curso.ano, curso.semestre
	FROM alumno, nota, curso, usuario
	WHERE nota.username = alumno.username
	AND alumno.username = usuario.username
	AND nota.notafinal <= 4.0
	AND nota.nrc = curso.nrc
	AND curso.sigla = '" . $_POST['sigla'] . "'";
	
	echo '<table border="1" class="table">';
	echo '<tr>';
	echo "<th>Nombres</th>";
	echo "<th>Apellido Paterno</th>";
	echo "<th>Apellido Materno</th>";
	echo "<th>Año</th>";
	echo "<th>Semestre</th>";
	echo "</tr>";
	
	foreach($db->query($query) as $row)
	{
		echo "<tr>";
		echo "<td>" . $row[0] . "</td>";
		echo "<td>" . $row[1] . "</td>";
		echo "<td>" . $row[2] . "</td>";
		echo "<td>" . $row[3] . "</td>";
		echo "<td>" . $row[4] . "</td>";
		echo "</tr>";
	}
	
	echo "</table>";

?>