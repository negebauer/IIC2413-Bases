<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>RENNAB</title>

</head>

<body>
	
	<h1>Resultado Consulta 6:</h1>

</body>

<?php
	try {
		$db = new PDO("pgsql:dbname=grupo5;host=localhost;port=5432;user=grupo5;password=gruponico"); 
		}
	catch(PDOException $e) {
		echo $e->getMessage();
		}
	
	$query="SELECT usuario.nombres, usuario.apellidop, usuario.apellidom, AVG(notafinal)
	FROM profesorcurso, nota, usuario
	WHERE profesorcurso.nrc = nota.nrc
	AND usuario.username = profesorcurso.username
	GROUP BY profesorcurso.username, usuario.username";
	
	echo '<table border="1">';
	echo '<tr>';
	echo "<th>Nombres</th>";
	echo "<th>Apellido Paterno</th>";
	echo "<th>Apellido Materno</th>";
	echo "<th>Promedio alumnos</th>";
	echo "</tr>";
	
	foreach($db->query($query) as $row)
	{
		echo "<tr>";
		echo "<td>" . $row[0] . "</td>";
		echo "<td>" . $row[1] . "</td>";
		echo "<td>" . $row[2] . "</td>";
		echo "<td>" . round($row[3], 1) . "</td>";
		echo "</tr>";
	}
	
	echo "</table>";

?>