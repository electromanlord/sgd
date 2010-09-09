

SELECT 
			CONCAT(
				IF(destino, CONCAT( u.login_usuario, "-" ), "" ),
				IF(area_destino,a.abve_nombre_area, au.abve_nombre_area)
			)	as ubicacion,
	r.id,
	r.id_documento,
	r.tipo,
	r.usuario,
	r.area,
	r.destino,
	r.area_destino,
	#max(r.fecha),
	d.codigo_documento
FROM(
					       SELECT
		                    hd.id_historial_documento AS id,
		                    id_documento,
		                    '6' AS tipo,
		                    null AS usuario, 
		                    null AS area,
		                    null AS destino,
		                    hd.id_area AS area_destino,				
		                    DATE_FORMAT(hd.fecha_historial_documento, '%Y-%m-%d %H:%i') AS fecha
						FROM
		                    historial_documentos AS hd				
						WHERE
		                    hd.id_documento IN (25228)
		                    AND hd.original_historial_documento = 1
		                    
						UNION
		                
						SELECT
		                    ha.id_historial_atencion AS id,
		                    id_documento,
		                    ha.tipo_historial_atencion AS tipo,
		                    ha.id_usuario AS usuario,
		                    ha.id_area AS area,
		                    ha.id_usuario_destino AS destino,
		                    ha.id_area_destino AS area_destino,
		                    DATE_FORMAT(ha.fecha_historial_atencion, '%Y-%m-%d %H:%i') AS fecha
		                FROM
		                    historial_atencion AS ha
		                WHERE
		                    ha.id_documento IN (25228) AND
		                    (ha.tipo_historial_atencion = 0 OR ha.tipo_historial_atencion = 1
		                     OR ha.tipo_historial_atencion = 2 OR ha.tipo_historial_atencion = 4)
		                    AND ha.original_historial_atencion = 1
		                     
		                UNION
		                
		                SELECT
		                    b.id_borrador_respuesta AS id,
		                    id_documento,
		                    3 AS tipo,
		                    b.id_usuario AS usuario,
		                    b.id_area AS area,
		                    b.id_destino AS destino,
		                    null AS area_destino,
		                    DATE_FORMAT(b.fecha_borrador_respuesta, '%Y-%m-%d %H:%i') AS fecha
		                FROM
		                    borradores_respuesta AS b
		                WHERE
		                    b.id_documento  IN (25228)
		                    
		                UNION
		                
						SELECT
		                    d.id_devuelto AS id,
		                    id_documento,
		                    '7' AS tipo,
		                    d.id_usuario AS usuario,
		                    d.id_area AS area,
		                    null AS destino,
		                    null AS area_destino,
		                    DATE_FORMAT(d.fecha_devolucion, '%Y-%m-%d %H:%i') AS fecha
						FROM
		                    devuelto AS d
						WHERE
		                    d.id_documento  IN (25228)
		                		
		             	ORDER BY fecha DESC
) r 
	INNER JOIN documentos d ON d.id_documento = r.id_documento
	LEFT JOIN areas a ON a.id_area = r.area_destino
	LEFT JOIN usuarios u ON u.id_usuario = r.destino
	LEFT JOIN areas au ON u.id_area = au.id_area
	
      GROUP BY id_documento 	