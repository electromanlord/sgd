<?php  
	include("includes.php");
	require_once("cls/class.usuarios.php");
	require_once("cls/class.pagina.php");
	require_once("cls/class.modulo_usuario.php");
	if(!$_SESSION['session'][3] == "SI" ){?>
		<script>location.href="error_permisos.php";</script>
 	<?
	}
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include("includes/inc.header.php"); ?>
<title>Administraci&oacute;n</title>
</head>
<body>
<table  id="principal"  align="left" cellpadding="0" cellspacing="0" width="100%" style="margin:0px; vertical-align:top">
	<tr>		
		<td  align="left" colspan="2"><?php  Plantilla::PlantillaEncabezado("ADMINISTRACION DE ACCESO A PAGINAS");?> </td>		
	</tr>
	<tr>
		<td class="menu"><?php  Plantilla::PlantillaIzquierdo();?></td>	
		<td  style="width:100%">
			<table  class="contenido" cellpadding="0" cellspacing="0" width="100%" align="left">										
				<tr>								
					<td style="width:100%; height:417px">
					<div id="cuerpo"><?php
					if($_SESSION['session'][3]=="SI" ){ 
						SeccionAdmin::SeccionAdminCabezera();
						switch($_GET['opcion']){																	
							case 'add':										
								SeccionAdmin::SeccionAdminAdd($_GET['id'], $_POST);
							break;
							case 'addDetail':										
								SeccionAdmin::SeccionAdminAddDetalle($_POST);
							break;
							case 'detail':
								SeccionAdmin::SeccionAdminDetalle($_GET['id1'],$_GET['id']);	
							break;							
							case 'list':
								SeccionAdmin::SeccionAdminList($_GET['id1']);	
							break;												
							default:	
								SeccionAdmin::SeccionAdminList($_GET['id1']);
							break; 
						}	 
					}else if($_SESSION['session'][3]=="NO") {
						echo "<div id=error> CUIDADO: Usted es Usuario del sistema pero no esta Autorizado para ver esta información </div><br><br>";		

					}else{
						echo " ERROR: Usted esta entrando de manera Incorrecta !!! " ;
					}	?>	
					</div>					
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


