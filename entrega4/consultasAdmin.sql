-- [SQL] Crear un nuevo curso
INSERT INTO curso
VALUES ($nrc, $sigla, $seccion, $ano, $semestre, $programa, $cupos);

-- [SQL] Agregar un profesor a un curso
INSERT INTO profesorcurso
VALUES ($nrc, $usernameProfesor);

-- [SQL] Ver informacion de un curso particular #2: LISTA ALUMNOS
SELECT usuario.username, usuario.nombres, usuario.apellidop, usuario.apellidom, nota.notafinal
FROM usuario, alumno, nota
WHERE usuario.username = alumno.username
AND nota.nrc = $nrcCurso
AND $usernameAdministrador IN (SELECT administrador.username FROM administrador)

-- [SQL] Ver informacion alumno #1: Informacion personal
SELECT usuario.rut, usuario.username, usuario.nombres, usuario.apellidop, usuario.apellidom, alumno.mailuc, usuario.paisorigen, usuario.sexo, usuario.estadocivil, usuario.fnacimiento, alumno.anoadmin, alumno.encausal
FROM usuario, alumno
WHERE usuario.username = alumno.username
AND alumno.username = $usernameAlumno
AND $usernameAdministrador IN (SELECT administrador.username FROM administrador)

-- [SQL] Ver informacion alumno #2: Historial ramos
SELECT curso.nrc, curso.sigla, curso.seccion, ramo.nombre, curso.ano, curso.semestre, nota.notafinal
FROM nota, ramo, curso
WHERE nota.username = $usernameAlumno
AND nota.nrc = curso.nrc
AND ramo.sigla = curso.sigla
ORDER BY curso.ano, curso.semestre, curso.sigla, ramo.nombre
AND $usernameAdministrador IN (SELECT administrador.username FROM administrador)

-- [SQL] Ver informacion alumno intercambio #1: Informacion personal
SELECT usuario.username, usuario.nombres, usuario.apellidop, alumno.mailuc, alumno.encausal, alumnointercambio.universidadprocedencia
FROM usuario, alumno, alumnointercambio
WHERE usuario.username = alumno.username
AND usuario.username = alumnointercambio.username
AND alumno.username = $usernameAlumno
AND $usernameAdministrador IN (SELECT administrador.username FROM administrador)

-- [PHP] Ver informacion alumno intercambio #2: Cursos que ha realizado y equivalente
$alumnos = $dbm->alumnos;
$cursos = $dbm->cursos;

$mongoid = new MongoId($usernameAlumno);
$idQuery = array("_id" => $mongoid);
$alumnoCursor = $alumnos->find($idQuery);
$alumnosMatch = $alumnos->find($idQuery);
$alumnosMatch->next();
$alumno = $alumnosMatch->current();

foreach (iterator_to_array($cursos->find()) as $curso)
{
	if (in_array($curso["_id"], $alumno["cursos"])) {
    	$sigla = $curso["sigla"];
    	$nombre = $curso["nombre"];
    	$equivalencia = $curso["equivalencia"];
    	$query = "SELECT sigla, nombre
    			FROM ramo
    			WHERE ramo.sigla = '{$equivalencia}';"
    	-- EJECUTAR QUERY
    	-- MOSTRAR INFO
	}
}
