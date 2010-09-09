

UPDATE 
	documentos_reporte as dr 
INNER JOIN 
	prioridades as p 	ON dr.prioridad=p.nombre_prioridad
SET 
	dr.fecha_respuesta = ( ADDDATE( dr.fecha_registro, 
				  p.tiempo_horas_respuesta_prioridad/24  ) ) 
WHERE 
	dr.fecha_respuesta = 0;
				
 