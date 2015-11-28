-- Ver todos los cursos que hay junto con los creditos y cupos
SELECT curso.nrc, ramo.nombre, curso.sigla, curso.seccion, curso.semestre, curso.ano, ramo.escuela, ramo.ncreditos, curso.cupos
FROM curso, ramo
WHERE ramo.sigla = curso.sigla
ORDER BY curso.sigla, curso.nombre;

-- Ver informacion de un curso particular #1: INFORMACION CURSO
SELECT curso.nrc, ramo.nombre, curso.sigla, curso.seccion, curso.semestre, curso.ano, ramo.escuela, ramo.ncreditos, curso.cupos, curso.programa
FROM curso, ramo
WHERE ramo.sigla = curso.sigla
AND curso.nrc = $nrcCurso

-- Buscador de cursos, $semestreCurso y $anoCurso DEBEN tener un valor
-- Valores por defecto aceptados:
-- $nombreRamo: ''
-- $siglaCurso: ''
-- $escuelaRamo: ''
-- $nombreProfesor: ''
-- $apellidoPProfesor: ''
-- $apellidoMProfesor: ''
SELECT curso.nrc, ramo.nombre, curso.sigla, curso.seccion, curso.semestre, curso.ano, ramo.escuela, ramo.ncreditos, curso.cupos
FROM curso, ramo
WHERE ramo.sigla = curso.sigla
AND ramo.nombre LIKE CONCAT($nombreRamo, '%')
AND curso.sigla LIKE CONCAT($siglaCurso, '%')
AND curso.semestre = $semestreCurso
AND curso.ano = $anoCurso
AND ramo.escuela LIKE CONCAT($escuelaRamo, '%')
AND (curso.sigla, curso.nrc) IN (SELECT curso.sigla, curso.nrc
								FROM curso, profesorcurso, usuario
								WHERE curso.nrc = profesorcurso.nrc
								AND profesorcurso.username = usuario.username
								AND (usuario.nombres LIKE CONCAT('%', $nombreProfesor, '%'))
									AND usuario.apellidop LIKE CONCAT('%', $apellidoPProfesor, '%')
									AND usuario.apellidom LIKE CONCAT('%', $apellidoMProfesor, '%')
								)
ORDER BY curso.sigla, ramo.nombre;
