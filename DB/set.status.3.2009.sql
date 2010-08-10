UPDATE
	arch_documento_archivo ana
SET
	ana.id_estado = 3
WHERE
	YEAR(ana.fecha) ="2009"
	AND ana.id_estado !=3