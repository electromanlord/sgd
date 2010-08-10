<?php  
	include("includes.php");
	require_once("libs/lib.php");
	require_once("cls/mesa_acceso_registro.cls.php");
	if(!$_SESSION['session'][3] == "SI" ){?>
		<script>location.href="Error_Permisos.php";</script>
 	<?
	}
	$table="registro";
	if(!isset($pag)){ $pag = 1; } 
    $tampag = 20;
	$reg1 = ($pag-1) * $tampag;
	$pags=array($pag,$tampag,$table,$reg1);
	set_time_limit(100);
	$menu = array(0,1,0,0,1,0); 

?>
<html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<script type="text/javascript">
<!--
function cambia_saldo(id_total){
	var id_doc = $("#id_documento").val();
	$("#capa_saldo").load("carga_saldo.php?horas=s&id_total="+id_total).fadeIn("slow");
	$("#fecha_respuesta").load("carga_saldo.php?fechar="+id_total+"&id="+id_doc).fadeIn("slow");
}
-->
</script>

<?php include("includes/inc.header.php"); ?>
<title>M&Oacute;DULO DE TRAMITE DOCUMENTARIO/ MESA DE PARTES </title>
</head>
<body <?php if(!$_SESSION['session'] && $_GET['opcion']!='recuperar'){?> onload='cargar(document.f1.usuario)' <?php }?> >
<span id="toolTipBox" width="200"></span>
<table  id="principal"  align="center"cellpadding="0" cellspacing="0" >
	<tr>		
		<td colspan="2"> <?php Plantilla::PlantillaEncabezado("DESPACHO DE DOCUMENTOS ");?> </td>		
	</tr>
	<tr>
		<td class="menu"><?php Plantilla::PlantillaIzquierdo();?></td>	
		<td>
			<table  class="contenido" cellpadding="0" cellspacing="0">	
            <tr>
				<td><?php  Plantilla::menuSuperior("mesa_acceso_registro.php",$menu,$_GET['id'],false);?></td>
			</tr>									
				<tr>								
					<td style="width:100%; height:417px"><?php 						
							switch($opcion){
										case 'add':
											Registro::RegistraAgregar();
										break;									
										case 'edit':	
											Registro::RegistraEditar($id);	
										break;
										case 'update':
											Registro::RegistraUpdate($id);
											Registro::RegistraListado($ide);	
										break;
										case 'delete':
											Registro::RegistraDelete($idcons);
										break;
										case 'list':
											Registro::RegistraListado($ide);	
										break;	
										case 'x':
											Registro::RegistraListado($ide);
										break;
										case 'guardar':
											Registro::RegistraGuardar();
											Registro::RegistraListado($ide);	
										break;	
										case 'agre':
											Registro::RegistraAgrega();
										break;	
										case 'despachar':	
											Registro::ConsultarDocumento($ids);	
											Registro::DespacharListarDestino($ids);			
										break;	
										case 'des_list':	
											Registro::ConsultarDocumento($ids);									
											Registro::DespacharListarDestino($ids);			
										break;	
										case 'des_guard':	
											Registro::DespacharGuardarDestino($ids);
											Registro::ConsultarDocumento($ids);		
											Registro::DespacharListarDestino($ids);		
										break;	
										case 'eliminar':	
											Registro::DespacharEliminarDestino($id,$ids);
											Registro::ConsultarDocumento($ids);		
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