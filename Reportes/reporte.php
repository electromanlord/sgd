<?php	
	require_once("../includes.php");
	require_once("consulta_reporte.php");
	
	$estilo = "";
	if($_REQUEST["tipo"]==2){
		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=Reporte_Busqueda.xls");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	}else{
		require('../libs/html2pdf/html2fpdf.php');
		ob_start();
		$estilo = "font-size:8px;";
	}
		
	$usuario = new Usuario($_SESSION['session'][0]);
	$reporte = new Reporte();
	$historial = $reporte->consultaAvanzada();
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Reporte de Busqueda</title>
<style type="text/css">
.cabecera_documento {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-style: normal;
	font-weight: bold;
	text-transform: capitalize;
	color: #FFFFFF;
	background-color: #2873AA;
}
.contenido {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #333333;
}
.contenido td{
	white-space:nowrap;
	overflow:hidden;
}
h1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 17px;
	font-style: normal;
	font-weight: bold;
	text-transform: capitalize;
	color: #114E8A;
}
.cuerpo_tabla {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: normal;
}
.negrita {
	font-weight: bold; 
}
</style>
</head>
<body>

	<table width="90%" border="0" align="center">
	  <tr>
		<td colspan="6"><div align="center"><img src="http://<?=$_SERVER['HTTP_HOST']?>/std/public_root/imgs/cabecera_reporte.jpg" width="887" height="64" /></div></td>
	  </tr>
	  <tr>
		<td height="51" colspan="6"><h1 align="center">REPORTE DE B&Uacute;SQUEDA</h1></td>
	  </tr>
	  <tr>
		<td width="8%" class="contenido negrita">Usuario :</td>
	    <td width="27%" class="contenido"><?=$usuario->getNombreCompleto()?></td>
	    <td width="34%" class="contenido">&nbsp;</td>
	    <td width="12%" class="contenido">&nbsp;</td>
	    <td width="7%" class="contenido negrita">Fecha :</td>
	    <td width="12%" class="contenido"><?=date("d/m/Y H:i:s")?></td>
	  </tr>
	  <tr>
	    <td height="18" colspan="6" class="contenido">&nbsp;</td>
      </tr>
	</table>
	<?php if(count($historial)>0){?>
	<table width="912" border="0" align="center" style="border-bottom:none">
	  <tr class="cabecera_documento">
		<td style="width:90px"><div align="center">N&ordm; Registro</div></td>
		<td style="width:200px"><div align="center">Remitente</div></td>
		<td style="width:260px"><div align="center">Documento</div></td>
		<td style="width:100px"><div align="center">Registrado</div></td>
		<td style="width:100px"><div align="center">F. Respuesta</div></td>
		<td style="width:30px"><div align="center">Estado</div></td>
		<td style="width:30px"><div align="center">Ubicacion</div></td>
		<? if($_REQUEST["tipo"]==2){?>
		<td><div align="center">Asunto</div></td>
		<? }?>
	  </tr>
	</table>
	<div style="width:908px; margin:auto auto; background:#2873AA">
	<table width="100%" border="0" align="center" class="contenido" style="table-layout:fixed; <?=$estilo?>" >
	<?php 	  
	  foreach($historial as $reg){
	  ?>
	  <tr bgcolor="#FFFFFF">	  	
		<td style="width:88px"><?=$reg["registro"]?></td>
		<td style="width:200px"><?=$reg["remitente"]?></td>
		<td style="width:260px"><?=$reg["documento"]?></td>
		<td style="width:100px"><?=$reg["fecha"]?></td>		
		<td style="width:100px"><?=$reg["fecha_r"]?></td>
		<td style="width:30px"><div align="center"><?=$reg["estado"]?></div></td>
		<td style="width:30px"><?=$reg["ubicacion"]?></td>
		<? if($_REQUEST["tipo"]==2){?>
		<td><?=$reg["asunto"]?></td>
		<? }?>
	  </tr>	 
	 <?php } ?>
	</table>
	</div>
	<?php }?>
</body>
</html>
<?php 
	if($_REQUEST["tipo"]==1){		
		$pdf=new HTML2FPDF('P','mm','a4');
		$htmlbuffer=ob_get_contents();
        ob_end_clean();
    	header("Content-type: application/pdf");
		$pdf->ubic_css="css/reporte.css";
		$pdf->DisplayPreferences('HideWindowUI');
		$pdf->AddPage();
		$pdf->WriteHTML($htmlbuffer);
		$pdf->Output("Reporte_Busqueda.pdf",'I');		
	}
?>