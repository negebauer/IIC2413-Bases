-- [SQL] Alumno cumple los requisitos y corequisitos de un ramo
-- _equivalentesAlumno debe ser el array con todas las siglas de los cursos que ya tiene cursado este alumno
-- Esta en consultasAdmin.sql
CREATE OR REPLACE FUNCTION AlumnoCumpleRequisitos (_username text, _sigla text, _equivalentesintercambio text[])
RETURNS BOOLEAN AS $$
DECLARE
	siglarequisito varchar(20);
	siglacorequisito varchar(20);
BEGIN
	FOR siglarequisito IN SELECT requisito.siglarequisito FROM requisito
    WHERE requisito.siglaramo = _sigla
    LOOP
        IF ((SELECT MAX(nota.notafinal)
        	FROM nota, curso
        	WHERE nota.nrc = curso.nrc
        	AND nota.username = _username
        	AND curso.sigla = siglarequisito) >= 4)
            OR (siglarequisito = ANY(_equivalentesintercambio)) THEN
    	ELSE
    		RETURN false;
    	END IF;
    END LOOP;
    FOR siglacorequisito IN SELECT corequisito.siglacorequisito FROM corequisito
    WHERE corequisito.siglaramo = _sigla
    LOOP
        IF siglacorequisito IN (SELECT curso.sigla
        						FROM nota, curso
        						WHERE nota.nrc = curso.nrc
        						AND nota.username = _username
        						AND curso.sigla = siglacorequisito) THEN
    	ELSE
    		RETURN false;
    	END IF;
    END LOOP;
    RETURN true;
END
$$ LANGUAGE plpgsql;

-- [SQL] Curso tiene cupos restantes
CREATE OR REPLACE FUNCTION CuposRestantes (_nrc integer)
RETURNS integer AS $$
BEGIN
	RETURN (SELECT cupos FROM curso WHERE curso.nrc = _nrc) -
		(SELECT COUNT(nota.nrc) FROM curso, nota WHERE curso.nrc = nota.nrc AND curso.nrc = _nrc);
END
$$ LANGUAGE plpgsql;

