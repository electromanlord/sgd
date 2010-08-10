<?
if($_GET[pdf]=='ok'){
	require_once('../../pdf/html2fpdf.php');
	ob_start();
}
?><?
require_once("../../includes.php"); 
require_once("../funciones/reportes.php"); 
require("../libs/verificar.inc.php"); 
require_once("../cls/informacionsinampe/partida_mensual.cls.php");
$link=new Conexion();
set_time_limit(100);

$Reporte=new Partida_Mensual();
$Reporte->ejecutor=$id;
$Reporte->axo=$_SESSION[inrena_4][2];
$Reporte->mes=$mes;

if(!empty($_REQUEST['anp'])) $_SESSION['anp']=$_REQUEST['anp'];

$Reporte->anp=$_SESSION['anp'];

$Reporte->fac=1;

$lnkmoneda="";
$md=$md;

if(empty($md)){
	$lnkmoneda='<a href="'.$_SERVER['PHP_SELF']."?id=".$id."&mes=".$mes."&md="."d".'"> Soles</a>';
	$moneda="Soles";
}else{ 
	$lnkmoneda='<a href="'.$_SERVER['PHP_SELF']."?id=".$id."&mes=".$mes.'">D&oacute;lares</a>';
	$Reporte->md=true;
	$Reporte->simbolomd=" $ ";
	$moneda="Dolares";
}

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Reporte</title>
<link rel="stylesheet" type="text/css" href="../../style.css">
<script language="javascript" src="../../js/js.js"></script> 
<script language="javascript" src="../js/reporte.js"></script>
<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
}
-->
</style></head>
<body >
<div id="barraBotones" name="barraBotones">
<?
if($_GET[pdf]!='ok'){ 
	///pdf
	$dir_pdf=$_SERVER['PHP_SELF'].'?id='.$id.'&md='.$md.'&mes='.$mes.'&pdf=ok';
	?>
	<table width="100%"><tr><td align="left">
	<a href="<?=$dir_pdf?>" ><img src="../../imgs/icon-pdf.gif" width="18" height="20" border="0" title="Descargar PDF"></a>
	</td>
	<td align="right">
	<a href="#" onClick="salida_impresora()" title="Imprimir"><img src="../../imgs/b_print.png" width="20" height="20" border="0"></a>	</td>
	</tr></table>
<? }?>
</div>
<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF">
		  <tr>	<th align='center' class="tit" bgcolor="#999999" >Presupuesto por Partida Mensual</th>  
		  </tr>
</table>
<hr width="100%">
<table width="600" border="0" cellpadding="2" cellspacing="0" bgcolor="#FFFFFF">
<? $Reporte->info_ejecutor();?></table>
<table width="100%" align="center"  border="0" cellpadding="2" cellspacing="0" bgcolor="#FFFFFF">
<tr><td align="right" colspan="4">
<font size="-1"><? if($_GET[pdf]=='ok') echo $moneda; else echo $lnkmoneda?>&nbsp;&nbsp;</font>
</td></tr></table>  
<table border="1" width="100%" cellspacing="0" cellpadding="0" class="tab" align="center" bgcolor="#FFFFFF">
	<? $Reporte->partidas();?>
</table>
<script language="javascript">
FullScreen();
</script>
</body>
</html>
<? 
if($_GET[pdf]=='ok'){
$htmlbuffer=ob_get_contents();
	ob_end_clean();
	header("Content-type: application/pdf");
$pdf = new HTML2FPDF('P','mm','a4x');
$pdf->ubic_css="../../style.css"; //agreg mio
	$pdf->DisplayPreferences('HideWindowUI');
	
$pdf->AddPage();
$pdf->WriteHTML($htmlbuffer);
$pdf->Output('presup_por_part_mensual.pdf','D');}
?>