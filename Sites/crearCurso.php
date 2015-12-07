<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>RENNAB</title>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

</head>

<?php

// #################### LIBRERIAS ####################
require_once('functions.php');

// #################### VARIABLES ####################


// #################### AHORA A HACER MAGIA ####################
if ($esAdmin)
{

echo "<style>
.error {color: #FF0000;}
</style>";

// FUENTE: http://www.w3schools.com/php/php_form_required.asp
// nrc: es definido por nosotros sumándole uno al máximo nrc existente en la tabla Cursos.
// sigla: El usuario tendrá que elegir la sigla de la lista de ramos ya existentes.
// profesor: El usuario tendrá que elegir al profesor de la lista de ramos ya existentes.
// programa, cupos, sección, año y semestre: Ingresados por usuario.


$sigla = $programa = $cupos = $profesor = $nrc = $seccion = $ano = $semestre = $cupos = "";
$siglaErr = $programaErr = $cuposErr = $profesorErr = $nrcErr = $seccionErr = $anoErr = $semestreErr = $cuposErr = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   if (empty($_POST["seccion"])) {
     $seccionErr = "*Requerido";
   }
   elseif (!(is_numeric($_POST["seccion"]))){
   	$seccionErr = "*Debe ser numérico";
   }
    
    } else { //Falta chequear que la seccion debe ser la menor posible
     $seccion = test_input($_POST["seccion"]);
   }
   
   if (empty($_POST["ano"])) {
     $anoErr = "*Requerido";
   }
    elseif (!(is_numeric($_POST["ano"]))){
   	$anoErr = "*Debe ser numérico";
   }
   else {
     $ano = test_input($_POST["ano"]);
   }

   if (empty($_POST["semestre"])) {
     $semestreErr = "*Requerido";
   }
    elseif (!(is_numeric($_POST["semestre"]))){
   	$semestreErr = "*Debe ser numérico";
   }
   else {
     $semestre = test_input($_POST["semestre"]);
   }

   if (empty($_POST["cupos"])) {
     $cuposErr = "*Requerido";
   }
    elseif (!(is_numeric($_POST["cupos"]))){
   	$cuposErr = "*Debe ser numérico";
   }
   else {
     $cupos = test_input($_POST["semestre"]);
   }


     
}

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}


$datosConsulta1 = "SELECT curso.sigla, ramo.nombre FROM curso, ramo WHERE ramo.sigla = curso.sigla GROUP BY curso.sigla, ramo.sigla ORDER BY curso.sigla";

echo '<form action="consultasEntrega3/consulta1.php" method="post">';
echo '<label><select name="sigla">';

foreach($db -> query($datosConsulta1) as $row)
{
	echo "<option value=$row[0]>$row[0] $row[1]</option>";
}

echo '</label>';
echo '<span class="byline"> </span>';
echo '<span class="byline"> </span>';
echo '<span class="byline"> </span>';
echo '<span class="byline"> </span>';
echo '<span class="byline"> </span>';
echo "<br/>";
echo '<input type="submit"/>';
echo '</form>';
							

<h2>PHP Form Validation Example</h2>
<p><span class="error">* required field.</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
   Name: <input type="text" name="name">
   <span class="error">* <?php echo $nameErr;?></span>
   <br><br>
   E-mail: <input type="text" name="email">
   <span class="error">* <?php echo $emailErr;?></span>
   <br><br>
   Website: <input type="text" name="website">
   <span class="error"><?php echo $websiteErr;?></span>
   <br><br>
   Comment: <textarea name="comment" rows="5" cols="40"></textarea>
   <br><br>
   Gender:
   <input type="radio" name="gender" value="female">Female
   <input type="radio" name="gender" value="male">Male
   <span class="error">* <?php echo $genderErr;?></span>
   <br><br>
   <input type="submit" name="submit" value="Submit"> 
</form>


echo "<h2>Your Input:</h2>";
echo $name;
echo "<br>";
echo $email;
echo "<br>";
echo $website;
echo "<br>";
echo $comment;
echo "<br>";
echo $gender;

}

-- [SQL] Crear un nuevo curso
INSERT INTO curso
VALUES ({$nrc}, '{$sigla}', {$seccion}, {$ano}, {$semestre}, '{$programa}', {$cupos});

-- [SQL] Agregar un profesor a un curso
INSERT INTO profesorcurso
VALUES ({$nrc}, '{$usernameProfesor}');

?>