<?php  
	include("includes.php");
	require_once("cls/class.usuarios.php");
	require_once("cls/class.modulo_usuario.php");
	if(!$_SESSION['session'][3] == "SI" ){?>
		<script>location.href="error_permisos.php";</script>
 	<?
	}		
	$menu = array(1,1,0,0,0,0);
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
		<td  align="left" colspan="2"><?php  Plantilla::PlantillaEncabezado("ADMINISTRACION DE USUARIOS");?> </td>		
	</tr>
	<tr>
		<td class="menu"><?php  Plantilla::PlantillaIzquierdo();?></td>	
		<td style="width:100%">
			<table  class="contenido" cellpadding="0" cellspacing="0" width="100%" align="left">
				<tr>
					<td><?php  Plantilla::menuSuperior("usuarios.php",$menu,$_GET['id'],false);?></td>
				</tr>
				<tr>								
					<td style="width:100%; height:417px">	
					<div id="cuerpo" > 	<?php  
					
					if( $_SESSION['session'][3] == "SI" ){  
						switch($_GET['opcion']){
							case 'new':										 
								Usuarios::UsuariosNew();		
							break;
							case 'add':
								Usuarios::UsuariosAdd();
								Usuarios::UsuariosList();			
							break;									
							case 'edit':										
								Usuarios::UsuariosEdit($_GET['id']);	
							break;
							case 'update':
								Usuarios::UsuariosUpdate($_GET['id'], $_POST);
								Usuarios::UsuariosList();			
							break;
							case 'delete':										 
								Usuarios::UsuariosDelete($_GET['id']);	
								Usuarios::UsuariosList();			
							break;
							case 'list':
								Usuarios::UsuariosList();	
							break;					
							default:	
								Usuarios::UsuariosList();
							 
							break; 
						}	
					}else if($_SESSION['session'][3]=="NO") {
						echo "<div id='error'> CUIDADO: Usted es Usuario del sistema pero no esta Autorizado para ver esta informacin </div><br><br>";		
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
