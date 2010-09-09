<?
require_once("../includes.php");
//If you use a php >= 5 this file is not needed
include("../cls/JSON.php");

header('Content-Type: text/html; charset="iso-8859-1"'); 

// create a JSON service
$json = new Services_JSON();

$page = $_GET['page']; // get the requested page 
$limit = $_GET['rows']; // get how many rows we want to have into the grid 
$sidx = $_GET['sidx']; // get index row - i.e. user click to sort 
$sord = $_GET['sord']; // get the direction 

if(!$sidx) $sidx =1;

$where = '';
$tipo=1;
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
		if($_GET['est']=='TP'){
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

if(!$_GET['reg']){
	if(!$_GET['rem']&&!$_GET['asu']&&!$_GET['fecha1']&&!$_GET['fecha2']&&!$_GET['doc']&&!$_GET['ubi']&&!$_GET['est']){ //La primera vez		
		if(!$_GET['todos'])
			$where = "WHERE dr.numero_registro like ''";
		else
			$where = "WHERE dr.numero_registro like '%%'";
			
	}elseif(!$_GET['fecha1']&&!$_GET['fecha3']){ //No se escogieron rangos de fecha
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
	$where="WHERE numero_registro like '".$_GET['anp']."%-%".$_GET['reg']."'";
}

	$sql = "SELECT
			dr.id_documento_reporte
			FROM
			documentos_reporte AS dr
			$where";

//echo $sql;
$query_sql = new Consulta($sql);

// calculate the number of rows for the query. We need this to paging the result
$count = $query_sql->NumeroRegistros();

// calculation of total pages for the query
if( $count >0 ) {
	$total_pages = ceil($count/$limit);
} else {
	$total_pages = 0;
}

// if for some reasons the requested page is greater than the total
// set the requested page to total page
if ($page > $total_pages) $page=$total_pages;

// calculate the starting position of the rows
$start = $limit*$page - $limit; // do not put $limit*($page - 1)
// if for some reasons start position is negative set it to 0
// typical case is that the user type 0 for the requested page
if($start <0) $start = 0;

// the actual query for the grid data		 
$SQL = "SELECT
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
		ORDER BY $sidx $sord LIMIT $start , $limit";

$query_SQL = new Consulta($SQL);

// constructing a JSON
$responce->page = $page;
$responce->total = $total_pages;
$responce->records = $count;
$i=0;
while($row = $query_SQL->ConsultaVerRegistro()) {
	$fecha_reg = date('d/m/Y H:i',strtotime($row['fecha']));
	$fecha_res = date('d/m/Y H:i',strtotime($row['fecha_r']));
    $responce->rows[$i]['id']=$row['id'];
    $responce->rows[$i]['cell']=array($row['asunto'],$row['registro'],$row['remitente'],$row['documento'],$fecha_reg,$fecha_res,$row['estado'],$row['ubicacion']);
    $i++;
}
// return the formated data
echo $json->encode($responce);
?>