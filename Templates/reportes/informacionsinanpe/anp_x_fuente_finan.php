<?
if($_GET[pdf]=='ok'){
	require_once('../../pdf/html2fpdf.php');
	ob_start();
}
?><?
require_once("../../includes.php"); 
require_once("../funciones/reportes.php"); 
require_once("../cls/informacionsinampe/anp_x_fuente_finan.cls.php");
require("../libs/verificar.inc.php"); 
$link=new Conexion();
set_time_limit(100);
/*echo "--$id";
echo "**".$_SESSION[inrena_4][2];
*/

$Reporte=new ANP_x_FF();
$Reporte->ejecutor=$id;
$Reporte->axo=$_SESSION[inrena_4][2];

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
.Estilo1 {color: #FFFFFF}
body {
	background-color: #FFFFFF;
}
-->
</style>
</head>
<body >

<div id="barraBotones" name="barraBotones">
<?
if($_GET[pdf]!='ok'){ 
	///pdf
	$dir_pdf=$_SERVER['PHP_SELF'].'?id='.$id.'&pdf=ok';
	?>
	<table width="100%"><tr><td align="left">
	<a href="<?=$dir_pdf?>" ><img src="../../imgs/icon-pdf.gif" width="18" height="20" border="0" title="Descargar PDF"></a>
	</td>
	<td align="right">
	<a href="#" onClick="salida_impresora()" title="Imprimir"><img src="../../imgs/b_print.png" width="20" height="20" border="0"></a>	</td>
	</tr></table>
<? }?>
</div>

<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
		  	<tr><th align='center' bgcolor="#999999" >
			ANP por Fuente de Financiamiento - Ejecutor</th>
			</tr>
</table>
		<hr width="100%">
<table width="600" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
			<?=$Reporte->Info_Ejecutor();?>
<tr><td><br></td></tr><tr><td><br></td></tr>			
</table>
		<table bgcolor="#FFFFFF" border="0" align="center" width="600" cellpadding="0" cellspacing="0"><tr><td>
		&nbsp;&nbsp;<font color="#00CC00" size="-1"><strong>Lista de ANP Asignadas</strong></font>
		</td></tr></table>
		<? $Reporte->Lista_ANP(); ?>
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
$pdf = new HTML2FPDF('P','mm','a4');
$pdf->ubic_css="../../style.css"; //agreg mio
	$pdf->DisplayPreferences('HideWindowUI');
	
$pdf->AddPage();
$pdf->WriteHTML($htmlbuffer);
$pdf->Output('anp_por_fntfin.pdf','D');}
?>