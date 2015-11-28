-- [PHP] Agregar alumnos de intercambio a base de datos (Completo)
$alumnos = $dbm->alumnos->find();
foreach (iterator_to_array($alumnos) as $alumno)
{
	$nombreRaw = $alumno["nombre"];
	$splited = explode(" ", $nombreRaw);
	$nombre = $splited[0];
	$apellido = $splited[1];
	$email = $alumno["email"];
	$universidad = $alumno["universidad"];
	$direccion = $alumno["direccion"];
	$id = $alumno["_id"];
	$query = "INSERT INTO usuario
			(username, password, direccion, mail, nombres, apellidop)
			VALUES ('{$id}', 1234, '{$direccion}', '{$email}', '{$nombre}', '{$apellido}');
			INSERT INTO alumno
			(username, mailuc, anoadmin)
			VALUES ();
			INSERT INTO alumnointercambio
			VALUES ('{$id}', '{$universidad}');"
	-- EJECUTAR QUERY
}

-- [PHP] Ver si algun curso equivalente de los de intercambio no esta en nuestra base de datos
$cursos = $dbm->cursos->find();
$cursosQueFaltan = "";
foreach (iterator_to_array($cursos) as $curso)
{
	$sigla = $curso["sigla"];
	$nombre = $curso["nombre"];
	$query = "SELECT COUNT(*)
			FROM ramo
			WHERE sigla = '{$sigla}';"
	-- EJECUTAR QUERY
	if ($query == 0) {
		$cursosQueFaltan .= $sigla . ": " . $nombre;
	}
}
if (count($cursosQueFaltan) > 0) {
	echo "Hay cursos que no tenemos en nuetras base de datos:<br>"
	foreach ($cursosQueFaltan as $curso)
	{
		echo "&emsp;$curso<br>";
	}
}