<?
	require_once("../includes.php");
	header('Content-Type: text/xml; charset="iso-8859-1"');
	echo '<?xml version="1.0" encoding="iso-8859-1"?>';

		$met = $_REQUEST["opcion"];

		switch($met){
		  case "actualiza": ?>
		  	  <raiz>
			  <? 
			  	if(!empty($_REQUEST['asunto'])){
                	$rpta= EditarAsunto($_REQUEST["ids"]);
                
				    if($rpta!=0){?>
                  	   <option value="OK">OK</option>
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


function EditarAsunto($ids){

	$asunto_g = utf8_decode($_REQUEST['asunto']);
	
	$sql = "UPDATE documentos
			SET asunto_documento='".$asunto_g."'
			WHERE id_documento=".$ids;
	$query=new Consulta($sql);
	return $query->RespuestaConsulta();

}

?>