<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>

<?php
// header('Content-Type: text/html; charset=ISO-8859-1');
try {
	$db = new PDO("pgsql:dbname=grupo5;host=localhost;port=5432;user=grupo5;password=gruponico"); 
	}
catch(PDOException $e) {
	echo $e->getMessage();
	}

echo "<h1>Resultado Consulta 4:</h1>";

$sigla=$_POST['sigla'];

$query="SELECT curso.ano, curso.semestre, MIN(notafinal), MAX(notafinal), AVG(notafinal), median(notafinal)
FROM nota, curso
WHERE curso.sigla = '$sigla'
AND curso.nrc = nota.nrc
GROUP BY curso.ano, curso.semestre";

echo '<table border="1">';
echo '<tr>';
echo "<th>Ano</th>";
echo "<th>Semestre</th>";
echo "<th>Nota minima</th>";
echo "<th>Nota maxima</th>";
echo "<th>Nota promedio</th>";
echo "<th>Mediana nota</th>";
echo "</tr>";

foreach($db->query($query) as $row)
{
	echo "<tr>";
	echo "<td>" . $row[0] . "</td>";
	echo "<td>" . $row[1] . "</td>";
	echo "<td>" . $row[2] . "</td>";
	echo "<td>" . $row[3] . "</td>";
	echo "<td>" . round($row[4], 3) . "</td>";
	echo "<td>" . $row[5] . "</td>";
	echo "</tr>";
}

echo "</table>";

?>