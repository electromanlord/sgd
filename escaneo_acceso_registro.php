<?php

include("includes.php");
require_once("cls/class.documentos.php");
require_once("cls/class.escaneos.php");

	if(!$_SESSION['session'][3] == "SI" ){?>
		<script>location.href="error_permisos.php";</script>
 	<?
	}

$escaneo = true;
$usuario = new Usuario($_SESSION['session'][0]);
$menu = array(0,1,1,0,0,0); 
set_time_limit(300);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php include("includes/inc.header.php"); ?>
	<script src="public_root/js/jquery.blockUI.js" type="text/javascript"></script>
	<script type="text/javascript" src="public_root/js/leyendas/cargar_estados.js"></script>
<title>Administraci&oacute;n</title>
</head>
<body>
    <span id="toolTipBox" width="200"></span>
	<table  id="principal"  align="left" cellpadding="0" cellspacing="0" width="100%" style="margin:0px; vertical-align:top">
        <tr>
    		<td colspan="2" align="left"><?php Plantilla::PlantillaEncabezado("ESCANEO DE DOCUMENTOS")?></td>
    	</tr>
		<tr>
			<td class="menu"><?php Plantilla::PlantillaIzquierdo();?></td>	
			<td>
				<table  class="contenido" cellpadding="0" cellspacing="0" width="100%" align="left">	
					<tr>
						<td><?php  Plantilla::menuSuperior("areas_acceso_registro.php",$menu,$_GET['id'],false);?></td>
					</tr>									
													
					<tr>								
						<td style="width:100%; height:417px">
				<?php 
					$escaneos = new Escaneos();
					$campo=$_REQUEST['campo'];
					$valor=$_REQUEST['valor'];
					switch($_GET['opcion']){

                        case 'add':
							$escaneos->EscaneaGuardar();
							$escaneos->EscaneaEditar($_GET['id']);															
						break;	

						case 'edit':																			
							$escaneos->EscaneaEditar($_GET['id']);	
						break;								

						case 'detalle':		
							$documento = new Documento($_GET['id']);																	
							$docs->detalleDocumentosPorUsuario($usuario, $documento);	
						break;

						case 'addha':
							$documento = new Documento($_GET['id']);
							$documento->addHistorialAtencion();	?> 
							<script type="text/javascript"> 
								location.replace("atencion_acceso_registro.php?opcion=detalle&id=<?php echo $_GET['id']?>");
							</script><?php 	
						break;

						case 'list':											
							Escaneos::EscaneaListado($_GET['ide']);				
						break;

						case 'activar':	
							$documento = new Documento($_GET['id']);												
							$documento->ActivarDocumento($usuario);	
							$docs->listarDocumentosPorUsuario($usuario);		
						break;

						case 'busqueda';
							Escaneos::Busqueda($campo, $valor);
							break;	

						default:											
							Escaneos::EscaneaListado($_GET['ide']);											

						break;
					}
					?>							
					</td>					
				</tr>			
			</table>
		</td>		
	</tr>
	<tr>
		<td colspan="2" class="pie"><?php Plantilla::PlantillaPie();?>	</td>
	</tr>	
</table>	
</body>
</html>