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

$siglaLetras = $siglaNumeros = $nombre = $ncreditos = $escuela = "";
$siglaLetrasErr = $siglaNumerosErr = $nombreErr = $ncreditosErr = $escuelaErr = "";

// #################### VERIFICAR USUARIO ####################
$arrayEsUsuario = vNumerosErr = erificarUsuario($username);
$esAdmin = $arrayEsUsuario[0];
$esAlumno = $arrayEsUsuario[1];
$esAlumnoIntercambio = $arrayEsUsuario[2];
$esProfesor = $arrayEsUsuario[3];

// #################### AHORA A HACER MAGIA ####################
if ($esAdmin){

$bienvenidaCrearRamo = array (
  "<h2>Crear Ramo</h2>",
  "<form method='post' action='crearRamo.php'>",
    "<p>&emsp;&emsp; Letras de la Sigla: <input type='text' name='siglaLetras'></p>",
    "<p>&emsp;&emsp; Números de la Sigla: <input type='number' name='siglaNumeros' min=‘0’ max=’9999’></p>",
    "<p>&emsp;&emsp; Nombre del Ramo: <input type='text' name='nombre'></p>",
    "<p>&emsp;&emsp; Número de Créditos: <input type='number' name=$ncreditos step=‘5’ min=‘5’ max=’10’></p>",
    "<p>&emsp;&emsp; Escuela: <input type='text' name='escuelaRamo'></p>",
    "<input type='submit' name='submit' value='Ingresar Ramo'>",
  "</form>"
  );

imprimirLineas($bienvenidaCrearRamo);

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
  if (empty($_POST["siglaLetras"])) {
    $siglaLetrasErr = "*Requerido";}
  elseif (strlen($_POST["siglaLetras"]) != 3){
    $siglaLetrasErr = "La sigla debe ser de solo tres caracteres";
    } else {
    $siglaLetras = test_input($_POST["siglaLetras"]);
  }

  if (empty($_POST["siglaNumeros"])){
    $siglaNumerosErr = "*Requerido";
  }
  elseif (intval($_POST["siglaNumeros"]) > 9999){
    $siglaNumerosErr = "El número debe ser mayor a 0 y menor o igual que 9999";
  } 
  elseif (intval($_POST["siglaNumeros"]) < 0){
    $siglaNumerosErr = "El número debe ser mayor a 0 y menor o igual que 9999";
  } else {
    $siglaNumeros = test_input($_POST["siglaNumeros"]);
  }

  if (empty($_POST["nombre"])) {
    $nombreErr = "*Requerido";
  } else {
    $nombre = test_input($_POST["nombre"]);
  }

  if (empty($_POST["ncreditos"])) {
    $ncreditosErr = "*Requerido";
  } else {
    $ncreditos = test_input($_POST["ncreditos"]);
  }

    if (empty($_POST["escuela"])) {
    $escuelaErr = "*Requerido";
  } else {
    $escuela = test_input($_POST["escuela"]);
  }

  function test_input($data) {
     $data = trim($data);
     $data = stripslashes($data);
     $data = htmlspecialchars($data);
     return $data;
  }

  //Nuestras Consultas
  $queryCrearCurso = "INSERT INTO Ramo
                      VALUES ('{$siglaLetras}{$siglaNumeros}', '{$nombre}', {$ncreditos}, '{$escuela}');";
}
}
?>