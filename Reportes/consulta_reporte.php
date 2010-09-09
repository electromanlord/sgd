<?php

class Reporte{

function consultaAvanzada(){

	$where = '';
	$tipo = 1;
	$sql_nvo = '';
	$ini_derivado = '';
	$fin_derivado = '';
	
	if($_GET['est']=='')
		$fin_derivado = "dr.estado like '%%'";
	else{
		$estado = $_GET['est'];
		
		if($_GET['est']=='DERIVADO'){//Busqueda en movimientos del estado
			$ini_derivado = "Inner Join movimientos AS m ON dr.id_documento_reporte = m.id_documento_reporte ";
			$fin_derivado = "m.estado like '".$estado."' AND m.origen like '%".$_GET['ori']."%'
						AND m.destino like '%".$_GET['des']."%'";
		}		
		else{
		if($_GET['est']=='P'){
			if(!$_GET['fecha3'])
				$fin_derivado = "dr.estado not like 'A'";
			else
				$fin_derivado = "m.estado not like 'A'";	
		}else{
			if(!$_GET['fecha3'])
				$fin_derivado = "dr.estado like '".$estado."'";
			else
				$fin_derivado = "m.estado like '".$estado."'";	
		}
	}
	}
	
	if(!$_GET['_reg']){
		if(!$_GET['rem']&&!$_GET['asu']&&!$_GET['fecha1']&&!$_GET['fecha2']&&!$_GET['doc']&&!$_GET['ubi']&&!$_GET['est']) //La primera vez
			$where = "WHERE dr.numero_registro like ''";
		elseif(!$_GET['fecha1']&&!$_GET['fecha3']){ //No se escogieron rangos de fecha
			$where = $ini_derivado.
					 "WHERE dr.remitente like '%".$_GET['rem']."%' AND dr.asunto like '%".$_GET['asu']."%'  
					  AND dr.numero_documento like '%".$_GET['doc']."%' AND dr.ubicacion like '".$_GET['ubi']."%'
					  AND ".$fin_derivado;	
		}elseif(!$_GET['fecha3']){//Solo se escogio busqueda por fecha de registro
			
			if(!$_GET['fecha2']){	
				$where =  $ini_derivado."WHERE dr.remitente like '%".$_GET['rem']."%' AND dr.asunto like '%".$_GET['asu']."%' 
						  AND dr.numero_documento like '%".$_GET['doc']."%' AND dr.ubicacion like '".$_GET['ubi']."%' AND 
						  $fin_derivado AND date(dr.fecha_registro) = '".formato_date('/',$_GET['fecha1'])."'";
			}else{
				$where =  $ini_derivado."WHERE dr.remitente like '%".$_GET['rem']."%' AND dr.asunto like '%".$_GET['asu']."%' 
						  AND dr.numero_documento like '%".$_GET['doc']."%' AND dr.ubicacion like '".$_GET['ubi']."%' AND 
						  $fin_derivado AND 
						  date(dr.fecha_registro) BETWEEN '".formato_date('/',$_GET['fecha1'])."' 
						  AND '".formato_date('/',$_GET['fecha2'])."'";
			}
		}elseif(!$_GET['fecha1']){//Solo se escogio busqueda por fecha de cambio
			
			$tipo=2;
			
			if(!$_GET['fecha4']){	
				$where  =   "Inner Join movimientos AS m ON dr.id_documento_reporte = m.id_documento_reporte
							WHERE
							dr.remitente LIKE  '%".$_GET['rem']."%' AND dr.asunto LIKE  '%".$_GET['asu']."%' 
							AND dr.numero_documento LIKE  '%".$_GET['doc']."%' AND dr.ubicacion LIKE  '".$_GET['ubi']."%' 
							AND (date(m.fecha_movimiento) =  '".formato_date('/',$_GET['fecha3'])."' AND
							$fin_derivado)
							GROUP BY
							dr.id_documento_reporte";
			}else{
				$where  =   "Inner Join movimientos AS m ON dr.id_documento_reporte = m.id_documento_reporte
							WHERE
							dr.remitente LIKE  '%".$_GET['rem']."%' AND dr.asunto LIKE  '%".$_GET['asu']."%' 
							AND dr.numero_documento LIKE  '%".$_GET['doc']."%' AND dr.ubicacion LIKE  '".$_GET['ubi']."%'  
							AND (date(m.fecha_movimiento) BETWEEN '".formato_date('/',$_GET['fecha3'])."' 
							AND '".formato_date('/',$_GET['fecha4'])."' AND $fin_derivado)
							GROUP BY
							dr.id_documento_reporte";
			}
		}else{//Se escogio por fecha de registro y fecha de cambio
			if(!$_GET['fecha2']&&!$_GET['fecha4']){ //No se escogio rangos
				$where  =   "Inner Join movimientos AS m ON dr.id_documento_reporte = m.id_documento_reporte
							WHERE
							dr.remitente LIKE  '%".$_GET['rem']."%' AND dr.asunto LIKE  '%".$_GET['asu']."%' 
							AND dr.numero_documento LIKE  '%".$_GET['doc']."%' AND dr.ubicacion LIKE  '".$_GET['ubi']."%' 
							AND date(dr.fecha_registro) = '".formato_date('/',$_GET['fecha1'])."' 
							AND (date(m.fecha_movimiento) =  '".formato_date('/',$_GET['fecha3'])."' 
							AND $fin_derivado)
							GROUP BY
							dr.id_documento_reporte";
			}			
			elseif(!$_GET['fecha2']){ //Solo se ecogio rango de fecha de cambio
				$where  =   "Inner Join movimientos AS m ON dr.id_documento_reporte = m.id_documento_reporte
							WHERE
							dr.remitente LIKE  '%".$_GET['rem']."%' AND dr.asunto LIKE  '%".$_GET['asu']."%' 
							AND dr.numero_documento LIKE  '%".$_GET['doc']."%' AND dr.ubicacion LIKE  '".$_GET['ubi']."%' 
							AND date(dr.fecha_registro) = '".formato_date('/',$_GET['fecha1'])."' 
							AND (date(m.fecha_movimiento) BETWEEN '".formato_date('/',$_GET['fecha3'])."' 
							AND '".formato_date('/',$_GET['fecha4'])."'	AND $fin_derivado)
							GROUP BY
							dr.id_documento_reporte";
			}
			elseif(!$_GET['fecha4']){ //Solo se escogio rango de fecha de registro
				$where  =   "Inner Join movimientos AS m ON dr.id_documento_reporte = m.id_documento_reporte
							WHERE
							dr.remitente LIKE  '%".$_GET['rem']."%' AND dr.asunto LIKE  '%".$_GET['asu']."%' 
							AND dr.numero_documento LIKE '%".$_GET['doc']."%' AND dr.ubicacion LIKE '".$_GET['ubi']."%' 
							AND date(dr.fecha_registro) BETWEEN '".formato_date('/',$_GET['fecha1'])."' 
							AND '".formato_date('/',$_GET['fecha2'])."'
							AND (date(m.fecha_movimiento) =  '".formato_date('/',$_GET['fecha3'])."' 
							AND $fin_derivado)
							GROUP BY
							dr.id_documento_reporte";
			}
			else{
				$where  =  "Inner Join movimientos AS m ON dr.id_documento_reporte = m.id_documento_reporte
							WHERE
							dr.remitente LIKE  '%".$_GET['rem']."%' AND dr.asunto LIKE  '%".$_GET['asu']."%' 
							AND dr.numero_documento LIKE '%".$_GET['doc']."%' AND dr.ubicacion LIKE '".$_GET['ubi']."%' 
							AND date(dr.fecha_registro) BETWEEN '".formato_date('/',$_GET['fecha1'])."' 
							AND '".formato_date('/',$_GET['fecha2'])."'
							AND (date(m.fecha_movimiento) BETWEEN  '".formato_date('/',$_GET['fecha3'])."' 
							AND '".formato_date('/',$_GET['fecha4'])."'	AND $fin_derivado)
							GROUP BY
							dr.id_documento_reporte";		
			}
								
		}
						
	}
	else{
		$where="WHERE numero_registro like '%".$_GET['_reg']."'";
	}
	
	$sql = "SELECT
			dr.id_documento_reporte AS id,
			dr.numero_registro AS registro,
			dr.numero_documento AS documento,
			dr.remitente AS remitente,
			dr.fecha_registro AS fecha,
			dr.fecha_respuesta AS fecha_r,
			dr.estado,
			dr.ubicacion AS ubicacion,
			dr.asunto AS asunto
			FROM
			documentos_reporte AS dr
			$where
			ORDER BY 1";	
	
	$query_sql = new Consulta($sql);
	
	while($row = $query_sql->ConsultaVerRegistro()) {	
		
		$fecha_reg = date('d/m/Y H:i',strtotime($row['fecha']));
		$fecha_res = date('d/m/Y H:i',strtotime($row['fecha_r']));
		$historial[] = array(
			'id'            =>	$row['id'],
			'registro'      =>	$row['registro'],
			'remitente'     =>	$row['remitente'],
			'documento'     =>	$row['documento'],
			'fecha'         =>	$fecha_reg,
			'fecha_r'       =>	$fecha_res,
			'estado'        =>	$row['estado'],
			'ubicacion'     =>	$row['ubicacion'],
			'asunto'     =>	$row['asunto']
		); 
	}
	return $historial;
}

function obtener_areas (){
	
	$historial = null;
	
	$sql = "SELECT
			a.id_area,
			a.nombre_area
			FROM
			areas AS a
			ORDER BY nombre_area ASC";
			
	$query = new Consulta($sql);		
	
	while($row = $query->ConsultaVerRegistro()){	
		$historial[] = array(
			'id'            =>	$row['id_area'],
			'area'     		=>	$row['nombre_area']
		); 
	}
	return $historial;
}

function obtener_area($id){
	
	$historial = null;
	
	$sql = "SELECT
			a.id_area,
			a.nombre_area,
			a.abve_nombre_area
			FROM
			areas AS a
			WHERE id_area = $id
			ORDER BY nombre_area ASC";
			
	$query = new Consulta($sql);		
	
	while($row = $query->ConsultaVerRegistro()){	
		$historial[] = array(
			'id'            =>	$row['id_area'],
			'area'     		=>	$row['nombre_area'],
			'abreviatura'	=>	$row['abve_nombre_area']
		); 
	}
	return $historial;
}

function obtener_usuarios_area($id_area){
	
	$historial = null;
	
	$sql = "SELECT
				u.id_usuario,
				u.nombre_usuario,
				u.apellidos_usuario
				FROM
				usuarios AS u
				WHERE
				u.id_area =  '$id_area'
				AND estado_usuario = 1";
			
	$query = new Consulta($sql);		
	
	while($row = $query->ConsultaVerRegistro()){	
		$historial[] = array(
			'id'            =>	$row['id_usuario'],
			'usuario'  	    =>	$row['nombre_usuario']." ".$row['apellidos_usuario'],
			'abreviatura'	=>	substr($row['nombre_usuario'],0,1).". ".$row['apellidos_usuario']
		); 
	}
	return $historial;
}

function obtener_movimientos_entrantes($usuario){

	$entrantes = array();
	$mes_actual = date("m"); //Dentro del año

	for ($mes = 1 ; $mes <= 12 ; $mes++){	
		if($mes <= $mes_actual){
			
			$sql = "SELECT
					m.id_movimiento,
					m.id_documento_reporte,
					m.origen,
					m.destino,
					m.fecha_movimiento,
					m.estado
					FROM
					movimientos AS m
					WHERE
					m.destino =  '$usuario' AND
					m.categoria =  '1' AND 
					MONTH(m.fecha_movimiento) = $mes
					ORDER BY
					m.id_documento_reporte ASC,
					m.id_movimiento ASC";
					
			$query = new Consulta($sql);		
			
			$contador = 0;
				
			while($row = $query->ConsultaVerRegistro()){	
				$contador++;
			}
			$entrantes[$mes-1] = $contador;
		}else{
			$entrantes[$mes-1] = 0;
		}
	}
	return $entrantes;
}

function obtener_movimientos_salientes($usuario){
	
	$salientes = array();
	$mes_actual = date("m"); //Dentro del año
		
	for ($mes = 1 ; $mes <= 12 ; $mes++){
		if($mes <= $mes_actual){
			$sql = "SELECT
					m.id_movimiento,
					m.id_documento_reporte,
					m.origen,
					m.destino,
					m.fecha_movimiento,
					m.estado
					FROM
					movimientos AS m
					WHERE
					m.origen =  '$usuario' AND
					m.categoria =  '1' AND 
					MONTH(m.fecha_movimiento) = $mes
					ORDER BY
					m.id_documento_reporte ASC,
					m.id_movimiento ASC";
					
			$query = new Consulta($sql);					
			$contador = 0;
			
			while($row = $query->ConsultaVerRegistro()){	
				$contador++;
			}		
			$salientes[$mes-1] = $contador;
		}else{
			$salientes[$mes-1] = 0;
		}
	}
		
	return $salientes;
}

function obtener_movimientos_usuario($usuario,$fecha_ini,$fecha_fin){
	
	$movimientos = array();
		
	$sql =  "SELECT
				dr.numero_registro AS registro,
				dr.remitente AS remitente,
				dr.asunto AS asunto,
				dr.fecha_registro AS fecha_registro,
				m.fecha_movimiento AS fecha_movimiento,
				m.accion AS accion,
				m.estado AS estado,
				m.observacion AS comentario,
				m.ubicacion AS ubicacion
				FROM
				movimientos AS m
				Inner Join documentos_reporte AS dr ON m.id_documento_reporte = dr.id_documento_reporte
				WHERE
				m.categoria =  '1' AND
				m.fecha_movimiento BETWEEN  '".formato_date('/',$fecha_ini)."' AND 
				'".formato_date('/',$fecha_fin)."' AND
				m.usuario LIKE  '".$usuario."'
				ORDER BY
				m.id_documento_reporte ASC";
	
	$query = new Consulta($sql);		
			
	while($row = $query->ConsultaVerRegistro()){	
		$movimientos[] = array(
			"registro"				=>		$row["registro"],
			"remitente"				=>		$row["remitente"],
			"asunto"					=>		$row["asunto"],
			"fecha_registro"		=>		$row["fecha_registro"],
			"fecha_movimiento"	=>		$row["fecha_movimiento"],
			"accion"					=>		$row["accion"],
			"estado"					=>		$row["estado"],
			"comentario"			=>		$row["comentario"],
			"ubicacion"				=>		$row["ubicacion"]
		);
	}		
				
	return $movimientos;
}

}
?>