<?php

// #################### LIBRERIAS ####################
require_once('global.php');

	function test_input($data)
	{
	   $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	function imprimirLineas($lineas)
	{
		foreach ($lineas as $linea) {
			echo $linea;
		}
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
		if (in_array($username, $alumnos))
		{
			$esAlumno = true;
		}
		if (in_array($username, $alumnosIntercambio))
		{
			$esAlumnoIntercambio = true;
		}
		if (in_array($username, $profesores))
		{
			$esProfesor = true;
		}

		return array ($esAdmin, $esAlumno, $esAlumnoIntercambio, $esProfesor);
    }

    function imprimirTabla($columnas, $data, $indexURL = -1, $url = "", $postVarName = "")
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
				$output = "SKIPME";
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
				if (!($output == "SKIPME") && $i == $indexURL)
				{
					$url = $url == "PROGRAMURL" ? "http://" . $output : $url;
					echo "<td>";
					echo "<form action='$url' method='post'>";
					echo "<input class=hidden name=$postVarName value=$output>";
					echo "<button type='submit' name='delete' value='Delete'>$output</button>";
					echo "</form>";
					echo "</td>";
				}
				elseif (!($output == "SKIPME"))
				{
					echo "<td>" . $output . "</td>";
				}
			}
			echo "</tr>";
		}
	}

?>