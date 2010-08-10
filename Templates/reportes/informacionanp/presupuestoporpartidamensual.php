<?
if($_GET[pdf]=='ok'){
	require_once('../../pdf/html2fpdf.php');
	ob_start();
}
?><?
session_start();
require_once("../../includes.php"); 
require_once("../funciones/reportes.php"); 
require_once("../cls/informacionanp/presupuestoporpartidamensual.cls.php");
require("../libs/verificar.inc.php"); 
set_time_limit(100);
$link=new Conexion();
$ReportePPPM=new  PresupuestoPorPartidasMensual($anpid);
$ReportePPPM->anpid=$id;
//echo $id;
$lnkmoneda="";
$md=$md;
if(empty($md)){ //(esta en soles)
	$lnkmoneda='<a href="'.$_SERVER['PHP_SELF']."?id=".$id."&md="."d".'">Soles</a>';
	$mnd="Soles";
}else{ // (esta en Dolar)
	$lnkmoneda='<a href="'.$_SERVER['PHP_SELF']."?id=".$id.'">Dolares</a>';
	$ReportePPPM->md=true;
	$ReportePPPM->simbolomd=" $ ";
	$mnd="Dólares";
}

if ($_POST){
$_SESSION[inrena_4][ffuente]="";
	for ($i=0;$i<count($_POST[S2]);$i++){
		$_SESSION[inrena_4][ffuente][]=$_POST[S2][$i];
	}
}
$ffuente=$_SESSION[inrena_4][ffuente];
$ReportePPPM->ftefto=$ffuente;
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
	$dir_pdf=$_SERVER['PHP_SELF'].'?id='.$id.'&md='.$md.'&pdf=ok';
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
		  <tr>	<th align=center class="tit" ><strong>
		    <p>Partidas Mensualizado - POA   
		      <?=axo($_SESSION[inrena_4][2]) ?>
		    </p>
		    <p><strong>
		      <? $row_nom="select * from anp where anp.id_anp='".$id."'";
			 $querynom=new Consulta($row_nom);
			 $row=$querynom->ConsultaVerRegistro();	
			 echo $row[3] ; ?>
		    </strong> </p></th>  
		  </tr>
		</table>
<hr width="100%">
		<table width="100%"  border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="15" nowrap>&nbsp;</td>
			<td width="80%">&nbsp;</td>
			<td width="" align="right"><? if($_GET[pdf]!='ok') echo $lnkmoneda; else echo $mnd;?></td>
		</tr>
		  <tr>
			<td colspan="3"><strong>FTE. FTO.-EJEC.: 
	        <?=$ReportePPPM->listar_ff_siglas($ffuente)?>  
		    </strong></td>
		</tr>
		</table>
	
	
			<table width="100%"  border="1" cellspacing="0" cellpadding="0" class="tab">
			  <tr bgcolor="#7B869C">
					<th class="th2" width="5%" rowspan="2" align="center">Partidas</th>
					<th class="th2" width="15%" rowspan="2" align="center">Descripci&oacute;n</th>
					<th class="th2" colspan="12" align="center">TOTAL ANUAL </th>
					<th class="th2" width="5%" rowspan="2" align="center">TOTAL</th>
			  </tr>
				<tr bgcolor="#7B869C">
			    <th class="th2" width="5%" align="center">ENE</th>
				<th class="th2" width="5%" align="center">FEB</th>
				<th class="th2" width="5%" align="center">MAR</th>
			    <th class="th2" width="5%" align="center">ABR</th>
			    <th class="th2" width="5%" align="center">MAY</th>
			    <th class="th2" width="5%" align="center">JUN</th>
			    <th class="th2" width="5%" align="center">JUL</th>
			    <th class="th2" width="5%" align="center">AGO</th>
			    <th class="th2" width="5%" align="center">SET</th>
			    <th class="th2" width="5%" align="center">OCT</th>
			    <th class="th2" width="5%" align="center">NOV</th>
			    <th class="th2" width="5%" align="center">DIC</th>
			</tr> 
			<? 
			$ReportePPPM->mostrar_Presupuesto($ffuente);
			?>
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
$pdf->AddPage();
$pdf->WriteHTML($htmlbuffer);
$pdf->Output('reporte.pdf','D');}
?>