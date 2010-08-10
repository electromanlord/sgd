<?php  
	include("includes.php");
	require_once("cls/class.areas.php");
	$menu = array(1,1,0,0,0,0);
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
		<td  align="left" colspan="2"><?php  Plantilla::PlantillaEncabezado("ADMINISTRACION DE AREAS");?> </td>		
	</tr>
	<tr>
		<td class="menu"><?php  Plantilla::PlantillaIzquierdo();?></td>	
		<td style="width:100%">
			<table  class="contenido" cellpadding="0" cellspacing="0" width="100%" align="left">								
				<tr>
					<td><?php  Plantilla::menuSuperior("areas.php",$menu,$_GET['id'],false);?></td>
				</tr>
				<tr>								
					<td style="width:100%; height:417px">	
					<div id="cuerpo" > 	<?php  
					if( $_SESSION['session'][3] == "SI" ){  
						switch($_GET['opcion']){
							case 'new':										 
								Areas::AreasNew();		
							break;
							case 'add':
								Areas::AreasAdd();
								Areas::AreasList();			
							break;									
							case 'edit':										
								Areas::AreasEdit($_GET['id']);	
							break;
							case 'update':
								Areas::AreasUpdate($_GET['id'], $_POST);
								Areas::AreasList();			
							break;
							case 'delete':										 
								Areas::AreasDelete($_GET['id']);	
								Areas::AreasList();			
							break;
							case 'detailUser':										 
								Areas::AreasDetalleUsuario($_GET['id']);			
							break;
							case 'detailArea':										 
								Areas::AreasDetalleArea($_GET['id']);			
							break;
							case 'addArea':										 
								Areas::GuardarDetalleArea($_GET['id'],$_POST);			
							break;
							case 'addUser':										 
								Areas::GuardarDetalleUsuario($_GET['id'],$_POST);			
							break;																					
							case 'list':
								Areas::AreasList();	
							break;					
							default:	
								Areas::AreasList();
							 
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

