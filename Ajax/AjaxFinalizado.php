<?
	require_once("../includes.php");
	require_once("../cls/class.plantilla_finalizado.php");
	
	header('Content-Type: text/xml; charset="iso-8859-1"');
	echo '<?xml version="1.0" encoding="iso-8859-1"?>';

		$met = $_REQUEST["opcion"];

		switch($met){
		  case "guarda": ?>
		  	  <raiz>
			  <? 
			  	if(!empty($_REQUEST['id'])&&ObtenerCodigoFinalizado($_REQUEST['id'])==""){
					$codigo = ObtenerNumeroDocumento($_REQUEST["tipo"],$_REQUEST["id"]);
                	$rpta= GuardarFinalizado($codigo,$_REQUEST["id"],$_REQUEST["tipo"]);                
				    if($rpta!=0){?>
                  	   <option value="<?=$codigo?>">OK</option>
					<? }
					else{?>
					  <option value="ERROR">ERROR</option>
					<?
					} 					
                }else{?>
					<option value="VACIO">VACIO</option>
				<?
				}?>
				</raiz> 
                <?
				break;
		}?>
	<?


function GuardarFinalizado($cod,$id,$tipo){
	
	$fecha_actual = time()-3600;
	$fecha=date("Y-m-d H:i:s",$fecha_actual);
	
	$sql = "UPDATE documento_finalizado
			SET 
			codigo_documento_finalizado='".$cod."',
			fecha_finalizado = '".$fecha."'
			WHERE id_documento_finalizado=".$id;
	$query=new Consulta($sql);
	
	if($query->RespuestaConsulta()){
		
		$sql_u = "SELECT ultimo_numero
				  FROM numero_documentos_respuesta
				  WHERE tipo_documento = ".$tipo;
		
		$query_u = new Consulta($sql_u);
		$row_u = $query_u->ConsultaVerRegistro(); 
		$ultimo = $row_u["ultimo_numero"];
		
		$sql_n = "UPDATE numero_documentos_respuesta
				 SET ultimo_numero='".($ultimo+1)."'
				 WHERE tipo_documento=".$tipo;
				
		$query_n = new Consulta($sql_n);
	}
	
	return $query_n->RespuestaConsulta();

}

?>
