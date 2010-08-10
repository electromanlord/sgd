<?php  
	include("../includes.php");
	require_once("AjaxFileUploader.inc.php");
	$menu = array(1,1,0,0,0,0);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>STD .:. Archivar Documento</title>
<link href="../public_root/css/general.css" type="text/css" rel="stylesheet" />
<link href="../public_root/css/admin.css" type="text/css" rel="stylesheet" />
<script language="javascript" type="text/javascript" src="../public_root/js/jquery-1.3.js"> </script>
<script language="javascript" type="text/javascript" src="../public_root/js/jquery.validate.js"> </script>
<script language="javascript" type="text/javascript" src="../public_root/js/admin.js"> </script>
<script type="text/javascript" src="uploader.js" ></script>
</head>
<body>
<?php  
	if( $_SESSION['session'][3] == "SI" ){  
?>
<fieldset>
	<legend>Archivar Documento</legend>
<table width="100%" border="0">
	<tr>
		<td height="19">Descripci&oacute;n</td>
		<td height="19"><div align="center">:</div></td>
		<td width="88%">&nbsp;</td>
	</tr>
	<tr>
		<td height="62" colspan="3">
			<form id="form2" name="form2" method="post" action="ArchivarCompletado(<?=$_REQUEST['id']?>)">															
				<div align="center">
					<textarea name="textarea" cols="55" rows="6"></textarea>
				</div>
			</form>
		</td>
	</tr>
	<tr>
		<td height="36" colspan="3">
		<?php
			$ajaxFileUploader = new AjaxFileuploader($uploadDirectory="../Archivados");	
			echo $ajaxFileUploader->showFileUploader('id1');
		?>
		</td>
	</tr>
	<tr>
		<td colspan="2" width="12%">
			<label><input type="button" name="Submit" value="Archivar" /></label>
		</td>
		<td>
			<label><input type="button" name="Submit2" value="Cancelar" /></label>
		</td>
	</tr>
</table>
<?
	}else if($_SESSION['session'][3]=="NO") {
		echo "<div id='error'> CUIDADO: Usted es Usuario del sistema pero no esta Autorizado para ver esta informacin </div><br><br>";		
	}else{
		echo " ERROR: Usted esta entrando de manera Incorrecta !!! " ;
	}	?>
</fieldset>
</body>
</html>

