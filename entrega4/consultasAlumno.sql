-- [SQL] Inscribir ramo
INSERT INTO nota(username, nrc)
(
	SELECT alumno.username, curso.nrc
	FROM alumno, curso
	WHERE alumno.username = $usernameAlumno
	AND curso.nrc = $nrcCurso
	AND (select * from AlumnoCumpleRequisitos(alumno.username, curso.sigla, $equivalentesintercambio)) = true
	AND (select * from CuposRestantes(curso.nrc)) > 0
);

-- Ver informacion alumno #1: Informacion personal
SELECT usuario.rut, usuario.username, usuario.nombres, usuario.apellidop, usuario.apellidom, alumno.mailuc, usuario.paisorigen, usuario.sexo, usuario.estadocivil, usuario.fnacimiento, alumno.anoadmin, alumno.encausal
FROM usuario, alumno
WHERE usuario.username = alumno.username
AND alumno.username = $usernameAlumno

-- Ver informacion alumno #2: Historial ramos
SELECT curso.nrc, curso.sigla, curso.seccion, ramo.nombre, curso.ano, curso.semestre, nota.notafinal
FROM nota, ramo, curso
WHERE nota.username = $usernameAlumno
AND nota.nrc = curso.nrc
AND ramo.sigla = curso.sigla
ORDER BY curso.ano, curso.semestre, curso.sigla, ramo.nombre