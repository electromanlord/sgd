<?php  include("includes.php");
	require_once("libs/lib.php");
	require_once("cls/ventanillas_acceso_registro.cls.php");
	
	$table="registro";
	if(!isset($pag)){ $pag = 1; } 
	$tampag = 20;
	$reg1 = ($pag-1) * $tampag;
	 
	$pags=array($pag,$tampag,$table,$reg1);
	set_time_limit(100);
?>
<html>
<head>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php include("includes/inc.header.php"); ?>
<title>M&Oacute;DULO DE TRAMITE DOCUMENTARIO/ REGISTRO	DE	DOCUMENTOS </title>
</head>
<body <?php if(!$_SESSION['session'] && $_GET['opcion']!='recuperar'){?> onload='cargar(document.f1.usuario)' <?php }?> >
<table  id="principal"  align="center"cellpadding="0" cellspacing="0" >
	<tr>		
		<td colspan="2"> <?php Plantilla::PlantillaEncabezado("REGISTRO	DE DOCUMENTOS ");?> </td>		
	</tr>
	<tr>
		<td class="menu"><?php Plantilla::PlantillaIzquierdo();?></td>	
		<td>
			<table  class="contenido" cellpadding="0" cellspacing="0">	
            <tr>
					<td><?php  Plantilla::menuSuperior("Ventanillas_acceso_registro.php",$menu,$_GET['id']);?></td>
				</tr>									
				<tr>								
					<td style="width:100%; height:417px">								
					<?php 									
							switch($opcion){
										case 'add':
											
											Registro::RegistraAgregar();
												
										break;									
										case 'edit':	
																			
											Registro::RegistraEditar($id);	
										break;
										case 'update':
											
											Registro::RegistraUpdate($id);
											Registro::RegistraListado();	
											
										break;
										case 'delete':
											Registro::RegistraDelete($id);
													
										break;
										case 'list':	
											Registro::RegistraListado();	
										break;	
										case 'x';
											Registro::RegistraListado();
										break;
										case 'guardar';
											
											Registro::RegistraGuardar();
											Registro::RegistraListado();		
										break;	
										case 'agre';
											
											Registro::RegistraAgrega();
											
										break;	
										case 'listremi';
											
											Registro::RegistraListRemitente();
										break;	
										case 'newremi';
											
											Registro::RegistraNewRemitente();
										break;	
										case 'editremi';
											
											Registro::RegistraEditRemitente($id);
											//Registro::RegistraUpdateRemitente($id);
										break;	
										case 'Updateremi';
											
											Registro::RegistraUpdateRemitente($id);
											Registro::RegistraListRemitente();
										break;	
										case 'guardremi';
											
											Registro::RegistraGuardarRemitente();
											Registro::RegistraAgregar();
											
										break;
										case 'busqueda';
											Registro::Busqueda($campo, $valor);
											//Registro::RegistraListado($ide);	
										break;						
										default:	
											
											Registro::RegistraListado();
										break;
										}
									///Registro::RegistraListado();
								 	
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