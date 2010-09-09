<?php 
#ini_set("display_errors",1);
include("includes.php"); 
/*
//Yonny
//Agregado 04/02/2010
if(!$_SESSION['session'] && !isset($_GET["error"])){
    if(!isset($_REQUEST["access"]) || $_REQUEST["access"]!=md5("20AcCeSso10")){
        Header("Location: ../sistemas/index.php");
    }
}
//---
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<!--Yonny -->
<!--Agregado 04/02/2010 
<base href="http://intranet.sernanp.gob.pe/std/" />
// -->

<?php include("includes/inc.header.php"); ?>
<title>Administraci&oacute;n</title>
</head>
<body>
<table  id="principal"  align="left" cellpadding="0" cellspacing="0" width="100%" style="margin:0px; vertical-align:top">
	<tr>		
		<td align="left" colspan="2"> <?php Plantilla::PlantillaEncabezado("ACCESO AL SISTEMA");?> </td>		
	</tr>
	<tr>
		<td class="menu"><?php Plantilla::PlantillaIzquierdo();?></td>	
		<td>
			<table  class="contenido" cellpadding="0" cellspacing="0" width="100%" align="left">									
				<tr>								
					<td style="width:100%; height:417px">								
					  <p>
					    <?php 
					if($_GET['opcion'] == 'recuperar'){
						include("recuperar_acceso.php");
					}else if($_SESSION['session']){
						include("inicio.php");
						
				
					}else(
						include("acceso.php")
					) ?></p>
				      
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
