<?php  
	include("includes.php");
	require_once("cls/class.anps.php");
	$menu = array(0,1,0,0,0,0);
	if(!$_SESSION['session'][3] == "SI" ){
		header("location: error_permisos.php");
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
		<td  align="left" colspan="2"><?php  Plantilla::PlantillaEncabezado("ADMINISTRACION DE ANPS");?> </td>		
	</tr>
	<tr>
		<td class="menu"><?php  Plantilla::PlantillaIzquierdo();?></td>	
		<td style="width:100%">
			<table  class="contenido" cellpadding="0" cellspacing="0" width="100%" align="left">								
				<tr>
					<td><?php  Plantilla::menuSuperior("anp.php",$menu,$_GET['id'],false);?></td>
				</tr>
				<tr>								
					<td style="width:100%; height:417px">	
					<div id="cuerpo" > 	<?php  
					if( $_SESSION['session'][3] == "SI" ){  
						switch($_GET['opcion']){
							case 'new':										 
								Anps::AnpsNew();		
							break;
							case 'add':
								Anps::AnpsAdd();
								Anps::AnpsList();			
							break;									
							case 'edit':										
								Anps::AnpsEdit($_GET['id']);	
							break;
							case 'update':
								Anps::AnpsUpdate($_GET['id'], $_POST);
								Anps::AnpsList();			
							break;
							case 'delete':										 
								Areas::AnpsDelete($_GET['id']);	
								Areas::AnpsList();			
							break;
							case 'detailUser':										 
								Anps::AreasDetalleUsuario($_GET['id']);			
							break;
							case 'detailArea':										 
								Anps::AreasDetalleArea($_GET['id']);			
							break;
							case 'addArea':										 
								Anps::GuardarDetalleArea($_GET['id'],$_POST);			
							break;
							case 'addUser':										 
								Anps::GuardarDetalleUsuario($_GET['id'],$_POST);			
							break;																					
							case 'list':
								Anps::AnpsList();	
							break;					
							default:	
								Anps::AnpsList();
							 
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

