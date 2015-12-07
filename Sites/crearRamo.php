<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>RENNAB</title>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

</head>

<?php

// #################### LIBRERIAS ####################
require_once('functions.php');

// #################### VARIABLES ESPECIFICAS ####################
$siglaLetras = $siglaNumeros = $siglaFinal = $nombre = $ncreditos = $escuela = "";
$siglaLetrasErr = $siglaNumerosErr = $nombreErr = $ncreditosErr = $escuelaErr = "";

function test_input($data) {
     $data = trim($data);
     $data = stripslashes($data);
     $data = htmlspecialchars($data);
     return $data;
  }

// #################### AHORA A HACER MAGIA ####################
if ($esAdmin){

$bienvenidaCrearRamo = array (
  "<h2>Crear Ramo</h2>",
  "<form method='post' action='crearRamo.php'>",
    "<p>&emsp;&emsp; Letras de la Sigla: <input type='text' name='siglaLetras'></p>",
    "<p>&emsp;&emsp; Números de la Sigla: <input type='number' name='siglaNumeros' min='0' max='9999'></p>",
    "<p>&emsp;&emsp; Nombre del Ramo: <input type='text' name='nombre'></p>",
    "<p>&emsp;&emsp; Número de Créditos: <input type='number' name=ncreditos step='5.0' min='5' max='10'></p>",
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

    if (empty($_POST["escuelaRamo"])) {
    $escuelaErr = "*Requerido";
  } else {
    $escuela = test_input($_POST["escuelaRamo"]);
  }

  //Nuestras Consultas

    $siglaFinal = $siglaLetras . $siglaNumeros;

  $queryCrearRamo = "INSERT INTO ramo
                    VALUES ('$siglaFinal', '$nombre', $ncreditos, '$escuela');";

  $dbp->query($queryCrearRamo);

  echo $queryCrearRamo;

  $queryRamoEnRamo = "SELECT COUNT(*)
                    FROM ramo
                    WHERE sigla = '$siglaFinal';";

  $ramoEnRamo = $dbp->query($queryRamoEnRamo)->fetchAll();
  if ($ramoEnRamo[0][0] > 0)
  {
   echo "Ramo inscrito correctamente";
  }
  else
  {
   echo "Ramo no fue inscrito correctamente ¿Seguro que ya no existe?";
  }

}
}
?>