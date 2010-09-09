<?	require_once("../includes.php");
	header('Content-Type: text/xml; charset="iso-8859-1"');
	echo '<?xml version="1.0" encoding="iso-8859-1"?>';

		$met = $_REQUEST["opcion"];

		switch($met){
		  case "arch":
                $rpta= DespacharArchivarDestino($_REQUEST['id'],$_REQUEST['com']);?>
                <raiz>
                <?
                if($rpta!=0){?>
                  <option value="<?=$rpta?>">OK</option>
                <?
				}
                else{?>
                  <option value="ERROR">ERROR</option>
                <? } ?>
                </raiz>
                <?
                break;
				
		  case "devol":
                $rpta= DespacharDevolverDestino($_REQUEST['id'],$_REQUEST['com']);?>
                <raiz>
                <?
                if($rpta!=0){?>
                  <option value="OK">OK</option>
                <?
				}
                else{?>
                  <option value="ERROR">ERROR</option>
                <? 
				}
				?>
                </raiz>
                <? 				
				break; }
			
function DespacharDevolverDestino($ids, $com){
	
	$com = utf8_decode($com);
	
	$sqlrep =  "SELECT id_documento_reporte as id
				FROM documentos_reporte
				WHERE id_documento=$ids";
					
	$qrep = new Consulta($sqlrep);
	$rowrep = $qrep->VerRegistro();					
	
	$dev_com = "INSERT into devuelto 
				values('',$ids,'".date("Y-m-d H:i")."',
				".$_SESSION['session'][5].",
				".$_SESSION['session'][0].",
				'$com')";
				
    $q_dev_com=new Consulta($dev_com);
	
	$area = new Area($_SESSION['session'][5]);
	$origen = $area->getNombre();
	$usuario = new Usuario($_SESSION['session'][0]);
		
	//Para el reporte
	$sha_r  =  "Insert INTO
				movimientos values('',
				'".$rowrep['id']."',
				".$q_dev_com->NuevoId().",
				'".$origen."',
				'DESPACHO GENERAL',
				'DEVOLVER A DESPACHO',
				'1',
				'".$usuario->getLogin()."',
				'$com',
				'".date("Y-m-d H:i:s")."',								
				'DEVUELTO',
				'',
				'6')";
	
	$qha_r =new Consulta($sha_r);
	
    $documento = new Documento($ids);
    $documento->actualizarEstado(5);
    $documento->ActualizaUbicacionArchivo("");
	
}

function DespacharArchivarDestino($ids, $com){
    
	$com = utf8_decode($com);
	$fecha = date("Y-m-d H:i:s");
	$usuario_duenio = 0; //Es de Despacho de Ara
	
	if($_REQUEST["tipo"]==1)//Es de Atencion
		$usuario_duenio = $_SESSION['session'][0];
			
	if($_REQUEST["cat"]==2){ //Es copia
	
		$arch   =  "Insert into archivo_copia 
					values('',$ids,
					".$usuario_duenio.",
					".$_SESSION['session'][5].",
					".$_SESSION['session'][0].",
					'".$fecha."',
					'$com')";
		$q_arch=new Consulta($arch);
		
		$estado = "";				
				
	}elseif($_REQUEST["cat"]==1){
							
		$arch   =  "Insert into archivo 
					values('',$ids,'".$fecha."',
					".$_SESSION['session'][5].",
					".$_SESSION['session'][0].",
					'$com')";		

		$q_arch=new Consulta($arch);
		
		$estado = "ARCHIVADO";	
	}	
	
		$id_historial = $q_arch->NuevoId();
		$sqlrep =  "SELECT id_documento_reporte as id
					FROM documentos_reporte
					WHERE id_documento=$ids";
		
		$qrep=new Consulta($sqlrep);
		$rowrep=$qrep->VerRegistro();
		
		//Datos del movimiento
		
		if($_REQUEST["tipo"]==1){//Es de Atencion
			$usuario_o = new Usuario($usuario_duenio);
			$origen = $usuario_o->getNombreCompleto();
		}else{
			$area_o = new Area($_SESSION['session'][5]);
			$origen = $area_o->getNombre();
			if($_REQUEST["cat"]==1)
				$ubicacion = $area_o->getAbreviatura();
		}
					
		$usuario = new Usuario($_SESSION['session'][0]);
		
		//Para el reporte
		$sha_r  =  "Insert INTO
					movimientos values('',
					'".$rowrep['id']."',
					".$id_historial.",
					'".$origen."',
					'".$origen."',
					'ARCHIVAR',
					'".$_REQUEST["cat"]."',
					'".$usuario->getLogin()."',
					'$com',
					'".$fecha."',								
					'$estado',
					'".$ubicacion."',
					'5')";
	
		$qha_r =new Consulta($sha_r);
		
		if($_REQUEST["cat"]==1){
			$documento = new Documento($ids);
			$documento->actualizarEstado(11);
			$documento->actualizarFechaRespuesta($fecha);
		}
		
		return $id_historial;	
					
	
}