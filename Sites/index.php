<head>
<script type="text/javascript">

	var host = "http://bases.ing.puc.cl/~grupo5/"

</script>
</head>

<body>
<h1>Sitio entrega 3</h1>
<h2>Bienvenido a la mejor pagina de Bases de Datos</h2>
<h3>Haz click en el link de la consulta que quieras realizar</h3>

<script type="text/javascript">

	// Consulta 1
    document.write('<p>Alumnos que reprobaron un curso</p>')
	document.write('<form action=' + host + 'consultasEntrega3/consulta1.php method="post">')
	document.write('<input type="text" name="sigla"/><br>')
	document.write('<input type="submit"/><br>')

    // Consulta 2
    document.write('<p>Alumnos que cumplen los requisitos de un curso y aun no lo han tomado</p>')
    document.write('<form action=' + host + 'consultasEntrega3/consulta2.php method="post">')
    document.write('<input type="text" name="sigla"><br>')
    document.write('<input type="submit"><br>')

	document.write('<a href="' + host + 'consultasEntrega3/consulta2.php">Consulta 2</a><br>')
	document.write('<a href="' + host + 'consultasEntrega3/consulta3.php">Consulta 3</a><br>')
	document.write('<a href="' + host + 'consultasEntrega3/consulta4.php">Consulta 4</a><br>')
	document.write('<a href="' + host + 'consultasEntrega3/consulta5.php">Consulta 5</a><br>')
	document.write('<a href="' + host + 'consultasEntrega3/consulta6.php">Consulta 6</a><br>')
</script>
</body>
