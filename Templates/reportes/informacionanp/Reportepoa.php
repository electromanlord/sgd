<?
if($_GET[pdf]=='ok'){
	require_once('../../pdf/html2fpdf.php');
	ob_start();
}
?>
<? 
require_once("../../includes.php"); 
require_once("../funciones/reportes.php"); 
require_once("../cls/reporteinformacionanp.cls.php");

require("../libs/verificar.inc.php"); 
$link=new Conexion();
$axo_poa=$_SESSION[inrena_4][2];
$anpid=$anpid; 
$sql ="SELECT a.*, c.nombre_categoria, d.nombre_departamento FROM `anp` AS `a`
Inner Join `categoria` AS `c` ON `c`.`id_categoria` = `a`.`id_categoria`
Inner Join `ubicacion` AS `u` ON `u`.`id_anp` = `a`.`id_anp`
Inner Join `departamento` AS `d` ON `d`.`id_departamento` = `u`.`id_departamento`
WHERE `a`.`id_anp` =  '".$anpid."' group by a.id_anp";
//echo $sql;
if ($rep<=2){
	$query=new Consulta($sql);
	$row_res_pag=$query->numregistros();
	$row=$query->ConsultaVerRegistro();
}
?>
<html >
<head>

<title>REPORTE</title>
<link href="../../style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../../js/js.js"></script> 
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #FFFFFF;
}
-->
</style><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body>
<div id="barraBotones" name="barraBotones">
<?
if($_GET[pdf]!='ok'&&$rep!=1){ 
	///pdf
	$dir_pdf=$_SERVER['PHP_SELF'].'?rep='.$rep.'&anpid='.$anpid.'&pdf=ok';
	?>
	<table width="100%"><tr><td align="left">
	<a href="<?=$dir_pdf?>" ><img src="../../imgs/icon-pdf.gif" width="18" height="20" border="0" title="Descargar PDF"></a>
	</td>
	<td align="right">
	<a href="#" onClick="salida_impresora()" title="Imprimir"><img src="../../imgs/b_print.png" width="20" height="20" border="0"></a>	</td>
	</tr></table>
<? }?>
</div>
<?
$ReporteANP=new reporteinformacionanp();
$ReporteANP->anpid=$anpid;
$ReporteANP->axo_poa=$axo_poa;

switch($rep){
	case '1':
		$ReporteANP->reporte_caratula_anp($row);
	break;	
	case '2':
		$ReporteANP->reporte_infomacion_poa($row);

	break;	
	case '3':
		$ReporteANP->reporte_desarollo_programatico(); 
	break;	
	}

?>
</body>
</html>
<? 
if($_GET[pdf]=='ok'){
$htmlbuffer=ob_get_contents();
	ob_end_clean();
	header("Content-type: application/pdf");
$pdf = new HTML2FPDF();
$pdf->ubic_css="../../style.css"; //agreg mio
	$pdf->DisplayPreferences('HideWindowUI');
$pdf->AddPage();
//$pdf->SetFont('Arial','',12);
  // $pdf->setBasePath("../../../");
$pdf->WriteHTML($htmlbuffer);
$pdf->Output('reporte.pdf','D');}
?>