<?
require_once("../includes.php");

cargar_plantilla();

function cargar_plantilla(){
	
	$plantila="";
	
	if($_REQUEST["parte"]==0){//cabecera
		
		$asunto=$_REQUEST["asu"];
		$referencia=$_REQUEST["ref"];
		$numero=ObtenerNumeroDocumento($_REQUEST["tipo"]);
        $destinatario=strtoupper($_REQUEST["remit"]);
		$cargo=strtoupper($_REQUEST["cargo"]);
		$fecha = ObtenerFecha();
		$abreviatura = ObtenerAbreviaturaArea();
		
		$sql = "Select contenido 
				FROM plantilla 
				WHERE tipo_documento=".$_REQUEST['tipo']." 
				and cabecera_pie = 0";
				
		$query_sql = new Consulta($sql);
		$row = $query_sql->verRegistro(); 
		
		$plantilla = $row["contenido"];
				
		$plantilla= str_replace("txtasunto",$asunto,$plantilla);
		$plantilla= str_replace("txtreferencia",$referencia,$plantilla);
		$plantilla= str_replace("txtnumero",$numero,$plantilla);
		$plantilla= str_replace("txtdestinatario",$destinatario,$plantilla);
		$plantilla= str_replace("txtfecha", $fecha,$plantilla);
		$plantilla= str_replace("txtabreviatura", $abreviatura,$plantilla);
		$plantilla= str_replace("txtcargo", $cargo,$plantilla);				
				
		echo $plantilla;
				
	}else{
		$jefe = new Usuario(ObtenerJefe());
        $nombre = $jefe->getNombreCompleto();
        $iniciales = $jefe->getIniciales();
        $cargo = $jefe->getCargo();
        $usuario = new Usuario($_SESSION['session'][0]);		
        
		$sql = "Select contenido
				FROM plantilla
				WHERE tipo_documento=".$_REQUEST['tipo']."
				and cabecera_pie=1";

		$query_sql=new Consulta($sql);
		$row = $query_sql->verRegistro();
		
		$plantilla = $row["contenido"];
				
		$plantilla= str_replace("txtjefe",$nombre,$plantilla);
		$plantilla= str_replace("txtcargo",$cargo,$plantilla);
        $plantilla= str_replace("txtiniciales",$iniciales,$plantilla);        
        $plantilla= str_replace("txtusuario",$usuario->getIniciales(),$plantilla);
		
		echo $plantilla;
	}		
		
}

function ObtenerNumeroDocumento($tipo){
	
	$codigo = ObtenerCodigoFinalizado();
	
	if(empty($codigo)){
		$sql = "Select ultimo_numero as ultimo
				FROM numero_documentos_respuesta
				WHERE tipo_documento=".$tipo;
		
		$query_sql=new Consulta($sql);
		$row = $query_sql->verRegistro();
		$codigo = $row["ultimo"]+1;
	}
	
	return $codigo;
}

function ObtenerCodigoFinalizado(){

	$sql = "SELECT
			df.codigo_documento_finalizado AS codigo
			FROM
			documento_finalizado AS df
			WHERE
			df.id_documento =  '".$_REQUEST['id']."'";

	$query_sql=new Consulta($sql);
	$row = $query_sql->verRegistro();
	
	return $row["codigo"];	
}

function ObtenerAbreviaturaArea(){

    $sql = "Select abve_nombre_area as abreviatura
			FROM areas
			WHERE id_area=".$_SESSION['session'][5];

	$query_sql=new Consulta($sql);
	$row = $query_sql->verRegistro();

    return $row["abreviatura"];

}

function ObtenerJefe(){
    $area = new Area($_SESSION['session'][5]);
    return $area->getIdResponsable();
}

function ObtenerFecha(){
	$fecha = date("d-m-Y");
	$nfecha = explode("-",$fecha);
	$dia = $nfecha[0];
	$mes = $nfecha[1];
	$anio = $nfecha[2];		
	
	
	
	switch($mes){
	
		case '01': $mes = "enero"; break;
		case '02': $mes = "febrero"; break;
		case '03': $mes = "marzo"; break;
		case '04': $mes = "abril"; break;
		case '05': $mes = "mayo"; break;
		case '06': $mes = "junio"; break;
		case '07': $mes = "julio"; break;
		case '08': $mes = "agosto"; break;
		case '09': $mes = "setiembre"; break;
		case '10': $mes = "octubre"; break;
		case '11': $mes = "noviembre"; break;
		case '12': $mes = "diciembre"; break;
	}
	$fecha = $dia." de ".$mes." del ".$anio;
	return $fecha;
}
?>