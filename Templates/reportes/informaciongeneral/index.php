<? require("../libs/verificar.inc.php"); ?>
<html>
<head>
<title>REPORTE</title>
<link href="../../style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../../js/js.js"></script> 
<script language="javascript" src="../js/reporte.js"></script> 
</head>
<body topmargin="0">

<form name=f1 action='reportes_general.php' method='POST'>
<table width=100% border=0 height=100% bgcolor=white class=table>
<tr BGCOLOR=Lavender height=30>
  <td style='font-size:12px;'><B>M&Oacute;DULO DE REPORTES / INFORMACI&Oacute;N GENERAL </B></td>
  </tr>
<tr><td ALIGN=CENTER valign=middle colspan=3 style='color:red;'>
<br><br><B><span style='font-size:12px;'>LISTADO DE REPORTES A MOSTRAR</span><BR><BR>
<?
$get="";
if($anpid && $anpnom && $anpcate){ 
	$get=$anpid;	
	?>
	<table> 
  <tr>
  	<td align="center"><h5><?=$anpcate." - ".$anpnom?></h5></td>
  </tr></table> 
  <?
  }
if($lectura=='S'){
?>
<table>
<th>No.</th><th>T&iacute;tulo</th>
<tr bgcolor=whitesmoke>
      <td align='center'>1</td>
					<td><a href=# onclick=ver_reporte_x_filtro_infgen('1','<?=$get?>') title='Mostrar Reporte' >Categorias</a></td>
</tr>
<tr bgcolor=whitesmoke>
      <td align='center'>2</td>
					<td><a href=# onclick=ver_reporte_x_filtro_infgen('4','<?=$get?>') title='Mostrar Reporte' >Partidas</a></td></tr>
					<tr bgcolor=whitesmoke>
      <td align='center'>3</td>
					<td><a href=# onClick="ver_cargos_anp()" title='Mostrar Reporte' >Cargos del Personal</a></td></tr>
<tr bgcolor=whitesmoke>
      <td align='center'>4</td>
					<td><a href=# onclick="ver_tareas()" title='Mostrar Reporte' >Tareas</a></td></tr>
<tr bgcolor=whitesmoke>
      <td align='center'>5</td>
					<td><a href=# onclick=ver_reporte_x_filtro_infgen('6','<?=$get?>') title='Mostrar Reporte' >Fuentes de Financiamiento</a></td>
</tr>				
<tr bgcolor=whitesmoke>
      <td align='center'>6</td>
					<td><a href=# onclick=ver_reporte_x_filtro_infgen('5','<?=$get?>') title='Mostrar Reporte' >ANP</a></td></tr>
</table>
<?
}else{
?>
<table><tr><td>
<br>Usted no tiene permiso de lectura para esta sección.
<tr><td></table>
<?
} 
?>
</td></tr>
</table>
</form>
</body>
</html>



