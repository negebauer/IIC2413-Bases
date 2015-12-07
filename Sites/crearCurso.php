<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>RENNAB</title>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

</head>

<?php

// #################### LIBRERIAS ####################
require_once('functions.php');

// #################### VARIABLES ####################
$programa = $cupos = $profesor = $nrc = $seccion = $ano = $semestre = $cupos = "";
$programaErr = $cuposErr = $profesorErr = $nrcErr = $seccionErr = $anoErr = $semestreErr = $cuposErr = "";

function test_input($data) {
     $data = trim($data);
     $data = stripslashes($data);
     $data = htmlspecialchars($data);
     return $data;
}

// #################### AHORA A HACER MAGIA ####################
if ($esAdmin)
{
  // FUENTE: http://www.w3schools.com/php/php_form_required.asp
  // nrc: es definido por nosotros sumándole uno al máximo nrc existente en la tabla Cursos.
  // sección: es definido por nosotros sumándole uno a la máxima sección existente en la tabla Cursos.
  // sigla: El usuario tendrá que elegir la sigla de la lista de ramos ya existentes.
  // programa, cupos, año y semestre: Ingresados por usuario.

  $formularioCrearCurso = array(
    "<form action='crearCurso.php' method='post'>",
    "<p>&emsp;&emsp; Año: <input type='number' name='ano' min='2010' max='2016'></p>",
    "<p>&emsp;&emsp; Semestre: <input type='number' name='semestre' min='1' max='2'></p>",
    "<p>&emsp;&emsp; Programa: <input type='text' name='programa'></p>",
    "<p>&emsp;&emsp; Cupos: <input type='number' name='cupos' min='0'></p>",
    "<p>Seleccionar Ramo</p>",
      "<select name=sigla>"
  );

  $cierreFormulario = array(
      "</select>",
      "<input type='submit' name='submit' value='Crear Curso'>",
    "</form>"
  );

  $queryRamos = "SELECT sigla, nombre
                  FROM ramo
                  ORDER BY sigla ASC, nombre ASC;";

  $ramosRowArray = $dbp->query($queryRamos)->fetchAll();

  foreach ($ramosRowArray as $ramosRow) {
            $siglaRamos = $ramosRow[0];
            $nombreRamos = $ramosRow[1];
            $infoRamos = $siglaRamos . " " . $nombreRamos;
            $option = "<option value=$siglaRamos>$infoRamos</option>";
            array_push($formularioCrearCurso, $option);
  }

  $formularioCrearCurso = array_merge($formularioCrearCurso, $cierreFormulario);

  imprimirLineas($formularioCrearCurso);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   if (empty($_POST["ano"])) {
     $anoErr = "*Requerido";
   }
   elseif (!(is_numeric($_POST["ano"]))){
   	$anoErr = "*Debe ser numérico";
   }
    
    else { //Falta chequear que la seccion debe ser la menor posible
     $ano = test_input($_POST["ano"]);
   }
   
   if (empty($_POST["semestre"])) {
     $semestreErr = "*Requerido";
   }
    elseif (!(is_numeric($_POST["semestre"]))){
   	$semestreErr = "*Debe ser numérico";
   }
   elseif (intval($_POST["semestre"]) > 2){
    $semestreErr = "Solo hay dos semestres: 1, 2.";
  }
   elseif (intval($_POST["semestre"]) < 1){
    $semestreErr = "Solo hay dos semestres: 1, 2.";
  }
   else {
     $semestre = intval(test_input($_POST["semestre"]));
   }

   if (empty($_POST["programa"])) {
     $programaErr = "*Requerido";
   }
    elseif (!(is_numeric($_POST["programa"]))){
    $programaErr = "*Debe ser numérico";
   }
   else {
     $programa = test_input($_POST["programa"]);
   }

  if (empty($_POST["cupos"])) {
     $cuposErr = "*Requerido";
   }
    elseif (!(is_numeric($_POST["cupos"]))){
    $cuposErr = "*Debe ser numérico";
   }
   else {
     $cupos = test_input($_POST["cupos"]);
   }

   $sigla = $_POST["sigla"];

   //NRC
   $queryNrc = "SELECT max(nrc)
                FROM Curso;";

  $nrc = 1 + $dbp->query($queryNrc)->fetchAll()[0][0];
  
  //Seccion
  $querySeccion = "SELECT max(Seccion)
                  FROM Curso
                  WHERE sigla = '$sigla'
                  AND ano = $ano
                  AND semestre = $semestre;";

  $seccion = 1 + $dbp->query($querySeccion)->fetchAll()[0][0];

  //Nuestras Consultas
  $queryCrearCurso = "INSERT INTO curso
                       VALUES ({$nrc}, '{$sigla}', {$seccion}, {$ano}, {$semestre}, '{$programa}', {$cupos});";
  
  $dbp->query($queryCrearCurso);

  $queryRevisarCurso = "SELECT COUNT(*)
                        FROM Curso
                        WHERE nrc = $nrc;";

  $cursoEnCurso = $dbp->query($queryRevisarCurso)->fetchAll();

  if ($cursoEnCurso[0][0] > 0)
  {
   echo "Curso inscrito correctamente";
  }
  else
  {
   echo "Curso no fue inscrito correctamente ¿Seguro que ya no existe?";
  }

}
}
?>