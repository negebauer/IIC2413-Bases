<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>RENNAB</title>

</head>

<body>

	<h1>RENNAB</h1>
	<h3>Realiza tu consulta favorita</h3>
	
	<h5>Consulta 2</h5>
	<p>Cursos que ha aprobado un alumno</p>
	<form action="consultasEntrega3/consulta2.php" method="post">
	<input type="text" name="alumno"/>
	<input type="submit"/>
	</form><br>
	
	<h5>Consulta 3</h5>
	<p>Cantidad de alumnos que cumplen los prerequisitos de un curso y no lo han tomado aun</p>
	<form action="consultasEntrega3/consulta3.php" method="post">
	<input type="text" name="sigla"/>
	<input type="submit"/>
	</form><br>
	
	<h5>Consulta 4</h5>
	<p>Nota mínima, máxima, promedio y mediana de un curso dado por cada semestre dictado</p>
	<form action="consultasEntrega3/consulta4.php" method="post">
	<input type="text" name="sigla"/>
	<input type="submit"/>
	</form><br>
	
	<h5>Consulta 5</h5>
	<p>Todos los profesores que ha tenido un alumno</p>
	<form action="consultasEntrega3/consulta5.php" method="post">
	<input type="text" name="alumno"/>
	<input type="submit"/>
	</form><br>
	
	<h5>Consulta 6</h5>
	<p>Promedio de notas que han obtenido los alumnos en los cursos de cada profesor</p>
	<form action="consultasEntrega3/consulta6.php" method="post">
	<input type="submit"/>
	</form><br>

</body>

<?php

	try {
		$db = new PDO("pgsql:dbname=grupo5;host=localhost;port=5432;user=grupo5;password=gruponico"); 
		}
	catch(PDOException $e) {
		echo $e->getMessage();
		}

	$datosConsulta1="SELECT curso.sigla, curso.ano, curso.semestre
	FROM curso";
	
	echo "<h5>Consulta 1</h5>";
	echo "<p>Alumnos que reprobaron un curso</p>";
	echo "<form action="consultasEntrega3/consulta1.php" method="post">";
	echo "<label><select name="sigla">";

	$i = 0;
	foreach($db->query($query) as $row)
	{
		echo "<option value="0">'$row[0]' '$row[1]' '$row[2]'</option>";
		$i = $i + 1;
	}

	echo "</label>";
	echo "<input type="submit"/>";
	echo "</form><br>";

?>
