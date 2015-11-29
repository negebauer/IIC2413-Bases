-- [SQL] Ver informacion de un curso particular #2: LISTA ALUMNOS
SELECT usuario.username, usuario.nombres, usuario.apellidop, usuario.apellidom, nota.notafinal
FROM usuario, alumno, nota
WHERE usuario.username = alumno.username
AND nota.nrc = {$nrcCurso}
AND '{$usernameProfesor}' IN (SELECT profesorcurso.username FROM profesorcurso WHERE nrc = {$nrcCurso})

-- [SQL] Poner nota a alumno
UPDATE nota
SET nota.notafinal = {$notaPuesta}
WHERE nota.username = '{$usernameAlumno}';

-- [SQL] Ver informacion alumno #1: Informacion personal
SELECT usuario.rut, usuario.username, usuario.nombres, usuario.apellidop, usuario.apellidom, alumno.mailuc, usuario.paisorigen, usuario.sexo, usuario.estadocivil, usuario.fnacimiento, alumno.anoadmin, alumno.encausal
FROM usuario, alumno
WHERE usuario.username = alumno.username
AND alumno.username = '{$usernameAlumno}'
AND '{$usernameProfesor}' IN (SELECT profesorcurso.username FROM profesorcurso WHERE nrc = {$nrcCurso})

-- [SQL] Ver informacion alumno #2: Historial ramos
SELECT curso.nrc, curso.sigla, curso.seccion, ramo.nombre, curso.ano, curso.semestre, nota.notafinal
FROM nota, ramo, curso
WHERE nota.username = '{$usernameAlumno}'
AND nota.nrc = curso.nrc
AND ramo.sigla = curso.sigla
ORDER BY curso.ano, curso.semestre, curso.sigla, ramo.nombre
AND '{$usernameProfesor}' IN (SELECT profesorcurso.username FROM profesorcurso WHERE nrc = {$nrcCurso})