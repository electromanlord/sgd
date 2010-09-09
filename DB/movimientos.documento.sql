SELECT 
	id,
	destino,
	area_destino,
	CONCAT(
		 IF (destino, CONCAT( u.login_usuario , "-" ) , " " ), 
		 a.abve_nombre_area
	) as ubicacion 
FROM (
			(
             SELECT
                 hd.id_historial_documento AS id,
                 '6' AS tipo,
                 null AS usuario,
                 null AS area,
                 null AS destino,
                 hd.id_area AS area_destino,				
                 hd.id_accion AS accion,
                 hd.original_historial_documento AS categoria,
                 null AS observacion,
                 hd.observacion_historial_documento AS comentario,
                 DATE_FORMAT(hd.fecha_historial_documento, '%Y-%m-%d %H:%i') AS fecha,
                 hd.id_estado as estado
				FROM
                    historial_documentos AS hd				
				WHERE
                    hd.id_documento =  25215    
                    
               )     
			UNION
              (  
				SELECT
                 ha.id_historial_atencion AS id,
                 ha.tipo_historial_atencion AS tipo,
                 ha.id_usuario AS usuario,
                 ha.id_area AS area,
                 ha.id_usuario_destino AS destino,
                 ha.id_area_destino AS area_destino,
                 ha.id_accion AS accion,
                 ha.original_historial_atencion AS categoria,
                 null AS observacion,
                 ha.observacion_historial_atencion AS comentario,
                 DATE_FORMAT(ha.fecha_historial_atencion, '%Y-%m-%d %H:%i') AS fecha,
                 ha.id_estado as estado
             FROM
                 historial_atencion AS ha
             WHERE
                 ha.id_documento =  25215 AND
                 (ha.tipo_historial_atencion = 0 OR ha.tipo_historial_atencion = 1
                  OR ha.tipo_historial_atencion = 2 OR ha.tipo_historial_atencion = 4)
         		)     
      	UNION
             (   
             SELECT
                 b.id_borrador_respuesta AS id,
                 3 AS tipo,
                 b.id_usuario AS usuario,
                 b.id_area AS area,
                 b.id_destino AS destino,
                 null AS area_destino,
                 b.id_accion AS accion,
                 b.categoria AS categoria,
                 b.descripcion_borrador_respuesta AS observacion,
                 b.comentario_adicional AS comentario,
                 DATE_FORMAT(b.fecha_borrador_respuesta, '%Y-%m-%d %H:%i') AS fecha,
                 null as estado
             FROM
                 borradores_respuesta AS b
             WHERE
                 b.id_documento = 25215
             )   
   	UNION
         	(
				SELECT
                 d.id_devuelto AS id,
                 '7' AS tipo,
                 d.id_usuario AS usuario,
                 d.id_area AS area,
                 null AS destino,
                 null AS area_destino,								
                 null AS accion,
                 '1' AS categoria,
                 null AS observacion,
                 d.descripcion AS comentario,
                 DATE_FORMAT(d.fecha_devolucion, '%Y-%m-%d %H:%i') AS fecha,
                 null as estado
				FROM
                    devuelto AS d
				WHERE
                    d.id_documento = 25215
            )        
		ORDER BY
           fecha DESC,
           categoria ASC
   	#LIMIT 0,1
   	
   	) 
		
		AS r
   	
LEFT JOIN usuarios u ON u.id_usuario = r.destino
LEFT JOIN areas a ON a.id_area = r.area_destino

   	