<?php  
	include("includes.php");
	require_once("cls/mesa_acceso_registro.cls.php");

	if(!$_SESSION['session'][3] == "SI" ){?>
		<script>location.href="error_permisos.php";</script>
 	<?
	}
	$menu = array(0,1,0,0,1,0);
	
	$unload = "";
	//if(isset($_REQUEST["opcion"])&&$_REQUEST["opcion"]!="list"&&$_REQUEST["opcion"]!="busqueda") 
		//$unload = "onunload=verificar_asunto()";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>M&Oacute;DULO DE TRAMITE DOCUMENTARIO/ MESA DE PARTES </title>
<?php include("includes/inc.header.php"); ?>
<script type="text/javascript" src="public_root/js/leyendas/cargar_estados.js"></script>
<script type="text/javascript">
function cambia_saldo(id_total){
	var id_doc = $("#id_documento").val();
	$("#capa_saldo").load("carga_saldo.php?horas=s&id_total="+id_total).fadeIn("slow");
	$("#fecha_respuesta").load("carga_saldo.php?fechar="+id_total+"&id="+id_doc).fadeIn("slow");
}
</script>
</head>
<body <?=$unload?>>

<table  id="principal"  align="left" cellpadding="0" cellspacing="0" width="100%" style="margin:0px; vertical-align:top">
	<tr>		
		<td colspan="2" align="left"> <?php Plantilla::PlantillaEncabezado("DESPACHO GENERAL ");?> </td>		
	</tr>
	<tr>
		<td class="menu"><?php Plantilla::PlantillaIzquierdo();?></td>	
		<td>
			<table  class="contenido" cellpadding="0" cellspacing="0" width="100%" align="left">	
            <tr>
				<td><?php  Plantilla::menuSuperior("mesa_acceso_registro.php",$menu,$_GET['id'],false);?></td>
			</tr>									
				<tr>								
					<td style="width:100%; height:417px"><?php
 							
						$opcion = $_REQUEST['opcion'];
						$ide = $_REQUEST['ide'];
						$ids = $_REQUEST['ids'];
						$campo = $_REQUEST['campo'];
						$valor = $_REQUEST['valor'];


							switch($opcion){
										case 'list':
											Registro::RegistraListado($ide);	
										break;	
										case 'despachar':	
											Registro::ConsultarDocumento($ids);	
											Registro::DespacharListarDestino($ids);			
										break;	
										case 'des_guard':	
											Registro::DespacharGuardarDestino($ids);
											Registro::ConsultarDocumento($ids);		
											Registro::DespacharListarDestino($ids);		
										break;	
										case 'eliminar':	
											Registro::DespacharEliminarDestino($_REQUEST["id"],$_REQUEST["ids"]);
											Registro::ConsultarDocumento($_REQUEST["ids"]);		
											Registro::DespacharListarDestino($ids);		
										break;											
										case 'busqueda';
											Registro::Busqueda($campo, $valor);
										break;			
										default:	
											Registro::RegistraListado($ide);
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