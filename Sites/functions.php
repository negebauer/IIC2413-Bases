<?php

$dbhost = "localhost";
$dbname = "test";
$mongo = new MongoClient("mongodb://$dbhost");
$dbm = $mongo->$dbname;

try {
	$dbp = new PDO("pgsql:dbname=grupo5;host=localhost;port=5432;user=grupo5;password=gruponico");
}
catch(PDOException $e) {
	echo $e->getMessage();
}

	function verificarUsuario($username)
    {
    	$dbp = $GLOBALS["dbp"];
    	$esAdmin = false;
		$esAlumno = false;
		$esAlumnoIntercambio = false;
		$esProfesor = false;

        $queryAdmins = "SELECT username
						FROM administrador;";
		
		$queryAlumnos = "SELECT username
						FROM alumno;";
		
		$queryAlumnosIntercambio = "SELECT username
									FROM alumnointercambio;";
		
		$queryProfesores = "SELECT username
							FROM profesor;";
		
		$adminsRowArray = $dbp->query($queryAdmins)->fetchAll();
		$alumnosRowArray = $dbp->query($queryAlumnos)->fetchAll();
		$alumnosIntercambioRowArray = $dbp->query($queryAlumnosIntercambio)->fetchAll();
		$profesoresRowArray = $dbp->query($queryProfesores)->fetchAll();
		
		$admins = [];
		$alumnos = [];
		$alumnosIntercambio = [];
		$profesores = [];
		
		foreach ($adminsRowArray as $admin)
		{
			array_push($admins, $admin[0]);
		}
		foreach ($alumnosRowArray as $alumno)
		{
			array_push($alumnos, $alumno[0]);
		}
		foreach ($alumnosIntercambioRowArray as $alumnoIntercambio)
		{
			array_push($alumnosIntercambio, $alumnoIntercambio[0]);
		}
		foreach ($profesoresRowArray as $profesor)
		{
			array_push($profesores, $profesor[0]);
		}
		
		if (in_array($username, $admins))
		{
			$esAdmin = true;
		}
		elseif (in_array($username, $alumnos))
		{
			$esAlumno = true;
		}
		elseif (in_array($username, $alumnosIntercambio))
		{
			$esAlumnoIntercambio = true;
		}
		elseif (in_array($username, $profesores))
		{
			$esProfesor = true;
		}

		return array ($esAdmin, $esAlumno, $esAlumnoIntercambio, $esProfesor);
    }

    function imprimirTabla($columnas, $data, $indexURL = 0, $url = "")
    {
    	echo '<table border="1" class="table">';
		echo '<tr>';
		foreach ($columnas as $columna) {
			echo "<th>" . $columna . "</th>";
		}
		echo "</tr>";
		foreach($data as $row) {
			$size = count($row);
			echo "<tr>";
			for ($i=0; $i < $size; $i++) {
				$output = "";
				if (!array_key_exists ($i, $row))
				{
					continue;
				}
				elseif (is_bool($row[$i]))
				{
					$output = $row[$i] ? 'Si' : 'No';
				}
				else
				{
					$output = $row[$i];
				}
				if (!($output == "") && $i == $indexURL)
				{
					echo "<td>" . $output . "</td>";
				}
				elseif (!($output == ""))
				{
					// $url = $url == "DATA" ? $output : $url;
					// $target = "_blank";
					// echo "<form name='myForm' target=$target action=$url method='post'>";
					// echo "<input type='hidden' name=$output' value='$output'/>";
					// echo "</form>";
					echo "<form action='$url' method='post'>";
					echo "<button type='submit' name=$programa value=$programa>$output</button>";
					echo "</form>";
					// echo "<td>" . $output . "</td>";
				}
			}
			echo "</tr>";
		}
	}

?>