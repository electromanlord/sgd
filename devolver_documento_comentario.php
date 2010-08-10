<?php  
	include("includes.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>STD .:. Devolver Documento</title>
<?php include_once("includes/inc.header.php"); ?>
</head>
<body>
<?php  
	if( $_SESSION['session'][3] == "SI" ){  
?>
<fieldset>
	<legend>Devolver Documento</legend>
	<form id="form2" name="form2" method="post" action="javascript:DevolverCompletado(<?=$_REQUEST['id']?>)">																
	
	<br/>
	<br/>
	<table width="100%" border="0">
	<tr>
		<td width="14%" height="26" class="Estilo22">Descripci&oacute;n</td>
	  <td width="2%" height="26" class="Estilo22"><div align="center">:</div></td>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td height="62" colspan="4">			
			<div align="center">
				<textarea name="textarea" cols="55" rows="6" id="comentario" class="caja"></textarea>
			</div>
		</td>
	</tr>
	<tr>
		<td colspan="2"></td>
		<td width="68%"><div align="right">
		  <input name="Submit" type="submit" class="boton" value="Devolver" />
	    </div></td>
	    <td width="16%"><div align="right">
	      <input name="Submit2" type="button" class="boton" value="Cancelar" onclick="cerrar_popups();"/>
      </div></td>
	</tr>
</table>
<?
	}else if($_SESSION['session'][3]=="NO") {
		echo "<div id='error'> CUIDADO: Usted es Usuario del sistema pero no esta Autorizado para ver esta informacin </div><br><br>";		
	}else{
		echo " ERROR: Usted esta entrando de manera Incorrecta !!! " ;
	}	?>
	</form>
</fieldset>
</body>
</html>
