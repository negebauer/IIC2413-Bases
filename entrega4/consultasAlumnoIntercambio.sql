-- [PHP] Obtengamos la lista de todos los alumnos primero
$alumnos = $db->alumnos->find();
foreach (iterator_to_array($alumnos) as $alumno)
{
	$nombre = $alumno["nombre"];
	$email = $alumno["email"];
	$universidad = $alumno["universidad"];
	$direccion = $alumno["direccion"];
	$id = $alumno["_id"];
}