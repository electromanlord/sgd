<?
require_once("../includes.php");
//If you use a php >= 5 this file is not needed
include("../cls/JSON.php");

header('Content-Type: text/html; charset="iso-8859-1"'); 

// create a JSON service
$json = new Services_JSON();
$get = (object) $_GET;

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
$copias = $_GET['copias'];
$usuarios = $_GET['usuarios'];

if($_GET['est']=='')
	$fin_derivado = "dr.estado not like 'A'";
else{
	$estado = $_GET['est'];
	
	if($_GET['est']=='DERIVADO'){//Busqueda en movimientos del estado
		$ini_derivado = "INNER JOIN movimientos AS m ON dr.id_documento_reporte = m.id_documento_reporte ";
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
				$fin_derivado = "dr.estado not like 'A'";  
			else
				$fin_derivado = "m.estado not like 'A'";	
		}
	}
}


$ubicacion_field ="	dr.ubicacion AS ubicacion, ";

if( $copias ){
	
	$ubicacion_field ="	m.ubicacion AS ubicacion, ";
	$ini_derivado .=" INNER JOIN movimientos AS m ON dr.id_documento_reporte = m.id_documento_reporte";
	$fin_derivado .=" AND m.categoria != 1 AND m.ubicacion LIKE '%$usuarios%' ";
}else if($_GET['usuarios'] && !$copias){

    $fin_derivado .=" AND  dr.ubicacion like '%$get->usuarios'  ";
}

if(!$_GET['rem']&&!$_GET['asu']&&!$_GET['fecha1']&&!$_GET['fecha2']&&!$_GET['doc']&&!$_GET['ubi']&&!$_GET['est']){ //La primera vez		
	if(!$_GET['todos'])
		$where = " WHERE dr.numero_registro like ''";
	else
		$where = " WHERE dr.numero_registro like '%%'";
	
}elseif(!$_GET['fecha1']&&!$_GET['fecha3']){ //No se escogieron rangos de fecha
	$where = $ini_derivado.
		 " WHERE dr.remitente like '%".$_GET['rem']."%'  
			AND dr.ubicacion like '".$_GET['ubi']."%'
		  AND ".$fin_derivado;
 
		  
}
	 
if($_GET['reg']){ 
    $reg = trim($_GET['reg']);
    if ( strlen($reg) <=5  ){
        $reg =str_pad( $_GET['reg'] , 5, "0", STR_PAD_LEFT);
        $where .=" AND( numero_registro like '%-$reg-%' ) "; 
    }else{
        $where .=" AND( numero_registro like '%$reg%' ) ";
    }
        /*
    */
} 

if($_GET['vencidos']){
    $where .=" AND 
	        DATEDIFF( 
			  	ADDDATE(dr.fecha_registro, 
				  p.tiempo_horas_respuesta_prioridad/24  ),
				CURDATE() 
				  ) <0
            AND dr.estado not like 'A'
    ";
}



if( $_GET['nodespachado'] ){

    $where ="
           WHERE 
        IF( p.tiempo_horas_respuesta_prioridad, (
	        DATEDIFF( 
			  	ADDDATE(dr.fecha_registro, 
				  p.tiempo_horas_respuesta_prioridad/24  ),
				CURDATE() 
				  ) 
				  ) , '-') = '-' 
                  AND dr.estado NOT  like 'A'
    ";
    if($_GET['rem']){
     $where .= " AND dr.remitente like '%".$_GET['rem']."%' ";    
    }
     
}else{
    
    $where .="
           AND 
        IF( p.tiempo_horas_respuesta_prioridad, (
	        DATEDIFF( 
			  	ADDDATE(dr.fecha_registro, 
				  p.tiempo_horas_respuesta_prioridad/24  ),
				CURDATE() 
				  ) 
				  ) , '-') != '-' 
    ";
}

	$sql = "SELECT
			dr.id_documento_reporte
			FROM
			documentos_reporte AS dr
            LEFT JOIN prioridades as p ON p.nombre_prioridad = dr.prioridad
			$where";

#echo $sql;
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
		$ubicacion_field
        IF( p.tiempo_horas_respuesta_prioridad, 
            DATE_FORMAT( ADDDATE(dr.fecha_registro, 
                p.tiempo_horas_respuesta_prioridad/24  ) , '%d/%m/%Y' )
            , '-')  AS fecha_r,
		dr.estado,
		dr.asunto AS asunto,
        dr.prioridad,
        IF( p.tiempo_horas_respuesta_prioridad, (
	        DATEDIFF( 
			  	ADDDATE(dr.fecha_registro, 
				  p.tiempo_horas_respuesta_prioridad/24  ),
				CURDATE() 
				  ) 
				  ) , 0) AS dias_faltantes  
		FROM
		documentos_reporte AS dr
        LEFT JOIN prioridades as p ON p.nombre_prioridad = dr.prioridad
		$where
		ORDER BY $sidx $sord LIMIT $start , $limit
		
		";

$query_SQL = new Consulta($SQL);
// constructing a JSON
#echo $SQL;
$responce->page = $page;
$responce->total = $total_pages;
$responce->records = $count;
$i=0;
while($row = $query_SQL->ConsultaVerRegistro()) {
    #echo $row['dias_faltantes'];
/*
    $sql_movimientos = "SELECT IF(m.categoria IN (5,6),'C','O' ) as cat
                        FROM movimientos m
                        WHERE id_documento_reporte = '".$row['id']."' 
                        ORDER BY fecha_movimiento
                        LIMIT 0,1";
									
	$query_movimientos = new Consulta($sql_movimientos);
    $original =  $query_movimientos->getRow();
*/
	$fecha_reg = date('d/m/Y',strtotime($row['fecha']));
    $responce->rows[$i]['id']=$row['id'];
    $responce->rows[$i]['cell'] = array( $row['asunto'],$row['registro'],$row['remitente'],$row['documento'],
                                $fecha_reg,$row['fecha_r'],$row['estado'],$row['ubicacion'], $row['dias_faltantes']);
    $i++;
}
// return the formated data
echo $json->encode($responce);
?>