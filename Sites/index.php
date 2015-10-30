<!DOCTYPE HTML>
<!--
	Solarize by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html>
	<head>
		<title>RENNAB by grupo5</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<!--[if lte IE 8]><script src="css/ie/html5shiv.js"></script><![endif]-->
		<script src="js/jquery.min.js"></script>
		<script src="js/jquery.dropotron.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-layers.min.js"></script>
		<script src="js/init.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/skel.css" />
			<link rel="stylesheet" href="css/style.css" />
		</noscript>
		<!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
	</head>

<!-- Declaración de variables para PHP -->
<?php

	try {
		$db = new PDO("pgsql:dbname=grupo5;host=localhost;port=5432;user=grupo5;password=gruponico"); 
		}
	catch(PDOException $e) {
		echo $e->getMessage();
		}

?>

	<body class="homepage">

		<!-- Header Wrapper -->
			<div class="wrapper style1">
			
			<!-- Header -->
				<div id="header">
					<div class="container">
							
						<!-- Logo -->
							<h1><a href="#" id="logo">RENNAB</a></h1>
						
						<!-- Nav -->
							<nav id="nav">
								<ul>
									<li class="active"><a href="index.php">Home</a></li>
								</ul>
							</nav>
	
					</div>
				</div>
				
			<!-- Banner -->
				<div id="banner">
					<section class="container">
						<h2>RENNAB</h2>
						<span>Realice la consulta deseada más abajo</span>
					</section>
				</div>

			</div>
		
		<!-- Consulta 1 -->
			<div class="wrapper style2">
				<section class="container">
					<header class="major">
						<center>
							<h2>Consulta 1</h2>
							<span class="byline">Alumnos que reprobaron un curso</span>
							<?php
								$datosConsulta1 = "SELECT curso.sigla, ramo.nombre FROM curso, ramo WHERE ramo.sigla = curso.sigla GROUP BY curso.sigla, ramo.sigla ORDER BY curso.sigla";
	
								echo '<form action="consultasEntrega3/consulta1.php" method="post">';
								echo '<label><select name="sigla">';
							
								foreach($db -> query($datosConsulta1) as $row)
								{
									echo "<option value=$row[0]>$row[0] $row[1]</option>";
								}
							
								echo '</label>';
								echo '<p></p><p></p>';
								echo '<input type="submit"/>';
								echo '</form><br>';
							?>
						</center>
					</header>
				</section>
			</div>

		<!-- Consulta 2 -->
			<div class="wrapper style2">
				<section class="container">
					<header class="major">
						<center>
							<h2>Consulta 2</h2>
							<span class="byline">Cursos que ha aprobado un alumno</span>
							<?php
								$datosConsulta2 = "SELECT alumno.username, usuario.nombres, usuario.apellidop, usuario.apellidom FROM alumno, usuario WHERE usuario.username = alumno.username ORDER BY usuario.apellidop, usuario.apellidom, usuario.nombres";
	
								echo '<form action="consultasEntrega3/consulta2.php" method="post">';
								echo '<label><select name="alumno">';
							
								foreach($db -> query($datosConsulta2) as $row)
								{
									echo "<option value=$row[0]>$row[2] $row[3] $row[1]</option>";
								}
							
								echo '</label>';
								echo '<input type="submit"/>';
								echo '</form><br>';
							?>
						</center>
					</header>
				</section>
			</div>

		<!-- Consulta 1 -->
			<div class="wrapper style2">
				<section class="container">
					<header class="major">
						<center>
							<h2>Consulta 3</h2>
							<span class="byline">Cantidad de alumnos que cumplen los prerequisitos de un curso y no lo han tomado aun</span>
							<?php
								$datosConsulta3 = "SELECT curso.sigla, ramo.nombre FROM curso, ramo WHERE ramo.sigla = curso.sigla GROUP BY curso.sigla, ramo.sigla ORDER BY curso.sigla";
	
								echo '<form action="consultasEntrega3/consulta3.php" method="post">';
								echo '<label><select name="sigla">';
							
								foreach($db -> query($datosConsulta3) as $row)
								{
									echo "<option value=$row[0]>$row[0] $row[1]</option>";
								}
							
								echo '</label>';
								echo '<input type="submit"/>';
								echo '</form><br>';
							?>
						</center>
					</header>
				</section>
			</div>

		<!-- Consulta 2 -->
			<div class="wrapper style2">
				<section class="container">
					<header class="major">
						<center>
							<h2>Consulta 4</h2>
							<span class="byline">Nota mínima, máxima, promedio y mediana de un curso dado por cada semestre dictado</span>
							<?php
								$datosConsulta4 = "SELECT curso.sigla, ramo.nombre FROM curso, ramo WHERE ramo.sigla = curso.sigla GROUP BY curso.sigla, ramo.sigla ORDER BY curso.sigla";

								echo '<form action="consultasEntrega3/consulta4.php" method="post">';
								echo '<label><select name="sigla">';
							
								foreach($db -> query($datosConsulta4) as $row)
								{
									echo "<option value=$row[0]>$row[0] $row[1]</option>";
								}
							
								echo '</label>';
								echo '<input type="submit"/>';
								echo '</form><br>';
							?>
						</center>
					</header>
				</section>
			</div>		<!-- Consulta 1 -->
			<div class="wrapper style2">
				<section class="container">
					<header class="major">
						<center>
							<h2>Consulta 5</h2>
							<span class="byline">Todos los profesores que ha tenido un alumno</span>
							<?php
								$datosConsulta5 = "SELECT alumno.username, usuario.nombres, usuario.apellidop, usuario.apellidom FROM alumno, usuario WHERE usuario.username = alumno.username ORDER BY usuario.apellidop, usuario.apellidom, usuario.nombres";

								echo '<form action="consultasEntrega3/consulta5.php" method="post">';
								echo '<label><select name="alumno">';
							
								foreach($db -> query($datosConsulta5) as $row)
								{
									echo "<option value=$row[0]>$row[2] $row[3] $row[1]</option>";
								}
							
								echo '</label>';
								echo '<input type="submit"/>';
								echo '</form><br>';
							?>
						</center>
					</header>
				</section>
			</div>

		<!-- Consulta 2 -->
			<div class="wrapper style2">
				<section class="container">
					<header class="major">
						<center>
							<h2>Consulta 6</h2>
							<span class="byline">Promedio de notas que han obtenido los alumnos en los cursos de cada profesor</span>
							<?php
								echo '<form action="consultasEntrega3/consulta6.php" method="post">';
								echo '<input type="submit"/>';
								echo '</form><br>';
							?>
						</center>
					</header>
				</section>
			</div>

	</body>
</html>