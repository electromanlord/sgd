<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="public_root/css/admin.css" type="text/css" rel="stylesheet" />
<link href="public_root/css/start/ui.all.css" rel="stylesheet">
<style>
	html,body{
		height:100%;
	}
	#contenido{
		width:100%;
		height:100%;
	}
	#contenido div{
		width:30%;
		padding:10px;
		position:absolute; 
		top:35%; 
		left:35%; 
	}
	
	#contenido p{
		margin : 3px;
	}
	
	#contenido a{
		text-decoration:none;
	}
	
</style>
</head>
<body>
<div id="contenido">
<div class='ui-state-error ui-corner-all' align='center'>
<table width="100%" border="0">
  <tr>
    <td style="vertical-align:middle"><img src="public_root/imgs/warning_1.png"/></td>
    <td style="vertical-align:middle">
	  <p>
	    <?
		if($_SESSION['session'][3]=="NO") {?>
	    <strong>CUIDADO : </strong> Usted es Usuario del sistema pero no esta Autorizado para ver esta informacion	
	    <?
		}else{?>	
	    <strong>ALERTA </strong>Su tiempo de sesion ha expirado </p>
	  <p style="margin-left:100px;">&nbsp;o </p>
	  <p> Usted esta entrando de manera Incorrecta</p>
			<?
		}
	?>	</td>
  </tr>
</table>
<br><a href='index.php'><strong>Regresar</strong></a></div>
</div>
</body>

