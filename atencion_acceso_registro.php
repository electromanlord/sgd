<?php 
	include("includes.php");
		require_once("cls/class.documentos.php");

	if(!$_SESSION['session'][3] == "SI" ){?>
		<script>location.href="error_permisos.php";</script>
 	<?
	}
	
$usuario = new Usuario($_SESSION['session'][0]);
$menu = array(0,1,0,0,0,0); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include("includes/inc.header.php"); ?>
<script src="public_root/js/jquery.blockUI.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript" src="public_root/js/leyendas/cargar_estados.js"></script>
<title>Administraci&oacute;n</title>
</head>
<body >
<table  id="principal" align="left" cellpadding="0" cellspacing="0" width="100%" style="margin:0px; vertical-align:top">
	<tr>		
		<td  align="left" colspan="2"><?php Plantilla::PlantillaEncabezado("ATENCION DE DOCUMENTOS")?></td>		
	</tr> 
	<tr>
		<td class="menu"><?php Plantilla::PlantillaIzquierdo()?></td>	
		<td>
			<table  class="contenido" cellpadding="0" cellspacing="0" width="100%" align="left">
				<tr>
					<td><?php  Plantilla::menuSuperior("atencion_acceso_registro.php",$menu,$_GET['id'],false);?></td>
				</tr>										
				<tr>								
					<td style="width:100%;height:417px"><?php 
					$docs = new Documentos();
					switch($_REQUEST['opcion']){
                        case 'deleteha':
							$documento = new Documento($_REQUEST['id']);
                            $documento->deleteHistorialBorrador($_REQUEST['idb']);
							$nuevo_doc = new Documento($_REQUEST['id']);
							$docs->detalleDocumentosPorUsuario($usuario, $nuevo_doc);							
						break;
						case 'detalle':		
							$documento = new Documento($_GET['id']);																	
							$docs->detalleDocumentosPorUsuario($usuario, $documento);	
						break;
						case 'list':											
							$docs->listarDocumentosPorUsuario($usuario);				
						break;
						case 'aprobar':	
							$documento = new Documento($_GET['id']);
							$documento->AprobarDocumento("");
							$docs->listarDocumentosPorUsuario($usuario);		
						break;
						case 'fin':	
							$documento = new Documento($_REQUEST['id']);
                            $documento->finalizarDocumento($_REQUEST['borrador']);
                            $docs->listarDocumentosPorUsuario($usuario);
							?>
                            <script>alert("Se Finalizo el documento");</script>
                            <?
						break;
						case 'busqueda': 
							$docs->listarDocumentosPorUsuario($usuario);
						break;		
						default:											
							$docs->listarDocumentosPorUsuario($usuario);
						break;
					} ?>							
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