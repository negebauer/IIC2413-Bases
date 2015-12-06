<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>RENNAB</title>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

</head>

<?php

// #################### PARA USAR INFO DE SESION ####################
session_start();

// #################### LIBRERIAS ####################
require_once('functions.php');

// #################### DECLARACION BASES DE DATOS ####################
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

// #################### VARIABLES GENERALES ####################
$username = $_SESSION['username'];	// username de quien hace la consulta
$esAdmin = false;					// si la consulta la hace un admin
$esAlumno = false;					// si la consulta la hace un alumno
$esAlumnoIntercambio = false;		// si la consulta la hace un alumno de intercambio
$esProfesor = false;				// si la consulta la hace un profesor

// #################### VARIABLES ESPECIFICAS ####################


// #################### VERIFICAR USUARIO ####################
$arrayEsUsuario = verificarUsuario($username);
$esAdmin = $arrayEsUsuario[0];
$esAlumno = $arrayEsUsuario[1];
$esAlumnoIntercambio = $arrayEsUsuario[2];
$esProfesor = $arrayEsUsuario[3];

// #################### AHORA A HACER MAGIA ####################

//FUENTE: http://www.w3schools.com/php/php_form_validation.asp

// define variables y las deja vacías
$nombreRamo = $siglaCurso = $escuelaRamo = $nombreProfesor =$apellidoPProfesor = $apellidoMProfesor = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $nombreRamo = test_input($_POST["nombreRamo"]);
   $siglaCurso = test_input($_POST["siglaCurso"]);
   $escuelaRamo = test_input($_POST["escuelaRamo"]);
   $nombreProfesor = test_input($_POST["nombreProfesor"]);
   $apellidoPProfesor = test_input($_POST["apellidoPProfesor"]);
   $apellidoMProfesor = test_input($_POST["apellidoMProfesor"]);
}

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}

<h2>Buscador de Cursos</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
   Nombre del Ramo: <input type="text" name="nombreRamo">
   <br><br>
   Sigla: <input type="text" name="siglaCurso">
   <br><br>
   Escuela: <input type="text" name="escuelaRamo">
   <br><br>
   Nombre del Profesor: <input type="text" name="nombreProfesor">
   <br><br>
   Apellido Paterno del Profesor: <input type="text" name="apellidoPProfesor">
   <br><br>
   Apellido Materno del Profesor: <input type="text" name="apellidoMProfesor">
   <br><br>
   <input type="submit" name="submit" value="Buscar"> 
</form>

echo "<h2>Tu última búsqueda:</h2>";
	echo $nombreRamo;
	echo "<br>";
	echo $siglaCurso;
	echo "<br>";
	echo $escuelaRamo;
	echo "<br>";
	echo $nombreProfesor;
	echo "<br>";
	echo $apellidoPProfesor;
	echo "<br>";
	echo $apellidoMProfesor;

//Nuestras Consultas
$queryBuscadorCursos = "SELECT curso.nrc, ramo.nombre, curso.sigla, curso.seccion, curso.semestre, curso.ano, ramo.escuela, ramo.ncreditos, curso.cupos
						FROM curso, ramo
						WHERE ramo.sigla = curso.sigla
						AND ramo.nombre LIKE CONCAT('{$nombreRamo}', '%')
						AND curso.sigla LIKE CONCAT('{$siglaCurso}', '%')
						AND curso.semestre = {$semestreCurso}
						AND curso.ano = {$anoCurso}
						AND ramo.escuela LIKE CONCAT('{$escuelaRamo}', '%')
						AND (curso.sigla, curso.nrc) IN (SELECT curso.sigla, curso.nrc
														FROM curso, profesorcurso, usuario
														WHERE curso.nrc = profesorcurso.nrc
														AND profesorcurso.username = usuario.username
														AND (usuario.nombres LIKE CONCAT('%', '{$nombreProfesor}', '%'))
															AND usuario.apellidop LIKE CONCAT('%', '{$apellidoPProfesor}', '%')
															AND usuario.apellidom LIKE CONCAT('%', '{$apellidoMProfesor}', '%')
														)
						ORDER BY curso.sigla, ramo.nombre;";
	
// ##### Hacemos las consultas #####
$infoBuscadorCursosRowArray = $dbp->query($queryBuscadorCursos)->fetchAll();

// ##### Tabla información alumno #####
$columnas = array (
	"NRC",
	"Curso",
	"Sigla",
	"Sección",
	"Semestre",
	"Año",
	"Escuela",
	"Créditos"
	"Cupos"
	);
imprimirTabla($columnas, $infoBuscadorCursosRowArray);

?>