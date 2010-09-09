<?php  	
	include("includes.php");
	require_once("libs/lib.php");
	require_once("cls/areas_acceso_registro.cls.php");
	require_once("cls/class.documento_finalizado.php");
	require_once("cls/class.documento_reporte.php");
	
	if(!$_SESSION['session'][3] == "SI" ){?>
		<script>location.href="error_permisos.php";</script>
 	<?
	}

	set_time_limit(100);
	$menu = array(0,1,0,0,1,0); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>M&Oacute;DULO DE TRAMITE DOCUMENTARIO/ DESPACHO DE <?=$row_td['nombre_area']?></title>
<?php include("includes/inc.header.php"); 
?>
<script src="public_root/js/jquery.blockUI.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript" src="public_root/js/leyendas/cargar_estados.js"></script>
<script type="text/javascript">
function cambia_saldo(id_total,id_doc){
	$("#capa_tiempo").load("carga_saldo.php?horas=s&amp;id_total="+id_total).fadeIn("slow");
	$("#fecha_respuesta").load("carga_saldo.php?fechar="+id_total+"&amp;id="+id_doc).fadeIn("slow");
}
</script>
</head>
<body>
<table  id="principal"  align="left" cellpadding="0" cellspacing="0" width="100%" style="margin:0px; vertical-align:top">
	<tr>		
		<td  align="left" colspan="2">
			<?php
				if($_SESSION['session'][6]) 
					$titulo = "DESPACHO DE AREA";
				else
					$titulo = "TRAMITE DE DOCUMENTOS";
				
				Plantilla::PlantillaEncabezado($titulo);
			?>
		</td>		
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
							switch($_REQUEST['opcion']){

								case 'list':
									Registro::RegistraListado($_REQUEST['ide']);		
								break;	

								case 'x':
									Registro::RegistraListado($_REQUEST['ide']);	
								break;

								case 'guardar':
									Registro::RegistraGuardar();
									Registro::RegistraListado($_REQUEST['ide']);			
								break;	

								case 'agre':
									Registro::RegistraAgrega();
								break;	

								case 'despachar':	
									Registro::ConsultarDocumento($_REQUEST['ids']);	
									//Registro::DespacharListarDestino($_REQUEST['ids']);			
								break;	

								case 'des_list':	
									Registro::ConsultarDocumento($_REQUEST['ids']);									
									//Registro::DespacharListarDestino($_REQUEST['ids']);			
								break;	

								case 'des_guard':	
									Registro::DespacharGuardarDestino($_REQUEST['ids']);
									Registro::ConsultarDocumento($_REQUEST['ids']);		
								break;	

								case 'eliminar':	
									Registro::DespacharEliminarDestino($_REQUEST['idp'],$_REQUEST['ids']);
									Registro::ConsultarDocumento($_REQUEST['ids']);		
								break;		

								case 'filtrar';
									Registro::RegistraFiltrar();
								break;	

								case 'busqueda';
									Registro::Busqueda($_REQUEST['campo'],$_REQUEST['valor']);
								break;	

								case 'desarch';
									Registro::DespacharDesArchivarDestino($_REQUEST['id']);
								break;
								
								case 'desfin';
									Registro::DespacharDesFinalizarDestino($_REQUEST['id']);
								break;			

								default:	
									Registro::RegistraListado($_REQUEST['ide']);	
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