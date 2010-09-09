<?
	require_once("../includes.php");
	header('Content-Type: text/xml; charset="iso-8859-1"');
	echo '<?xml version="1.0" encoding="iso-8859-1"?>';

		$met = $_REQUEST["metodo"];

		switch($met){
		  case "actualiza": ?>
		  	  <raiz>
			  <? 
	               	$rpta= ActualizarEstado($_REQUEST["ids"]);                
				    if($rpta!=0){?>
                  	   <option value="OK">OK</option>
					<? }
					else{?>
					  <option value="ERROR">ERROR</option>
					 <? }?>									
				</raiz> 
             <?
				break;
		}?>
	<?


function ActualizarEstado($ids){
	
	///////////////////////////////// big
	
	

$sql_x = " INSERT INTO documento_estado_CI (id_documento,estado,fech_hor) VALUES ('".$_REQUEST["ids"]."',".$_REQUEST["est"].",'".date("Y-m-d H:i:s")."')";
			  
	$query_x = new Consulta($sql_x);
	
	
/////////////////////////////////
	
	
	$sql_d = "INSERT INTO arch_documento_archivo (id_documento, fecha, id_estado)
			  VALUES ('".$_REQUEST["ids"]."','".date("Y-m-d H:i:s")."',".$_REQUEST["est"].")";
			  
	$query_d = new Consulta($sql_d);

	
	
	
	
	return $query_d->RespuestaConsulta();

}

?>