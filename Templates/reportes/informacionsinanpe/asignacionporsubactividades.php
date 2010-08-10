<?
if($_GET[pdf]=='ok'){
	require_once('../../pdf/html2fpdf.php');
	ob_start();
}
?><?
require_once("../../includes.php"); 
require_once("../funciones/reportes.php"); 
require_once("../cls/informacionsinampe/asignacionporsubactividades.cls.php");
require("../libs/verificar.inc.php"); 
$link=new Conexion();
set_time_limit(100);

$ReporteAAnpS=new AsignacionporSubactividades();

$lnkmoneda="";
$md=$md;

if(empty($md)){
	$lnkmoneda='<a href="'.$_SERVER['PHP_SELF']."?id=".$id."&md="."d".'">Soles</a>';
	$moneda="Soles";
}else{ 
	$lnkmoneda='<a href="'.$_SERVER['PHP_SELF']."?id=".$id.'">Dolares</a>';
	$moneda="Dolares";
	$ReporteAAnpS->md=true;
	$ReporteAAnpS->simbolomd=" $ ";
}

if ($_POST){
$_SESSION[inrena_4][ffuente]="";
	for ($i=0;$i<count($_POST[S2]);$i++){
		$_SESSION[inrena_4][ffuente][]=$_POST[S2][$i];
	}
}

$ffuente=$_SESSION[inrena_4][ffuente];
$ReporteAAnpS->ftefto=$ffuente;
$Anps=$ReporteAAnpS->ListarAnps();
$numAnps=count($Anps);
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

<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF">
		  <tr>	<th align='center' class="tit" bgcolor="#999999" >Asignaciones ANP por Subactividades - POA   <?=axo($_SESSION[inrena_4][2]) ?></th>  
		  </tr>
</table>
<hr width="100%">
<table width="100%"  border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
		<tr>
			<td width="15" nowrap>&nbsp;</td>
			<td width="80%">&nbsp;</td>
			<td align="right">&nbsp;<? if($_GET[pdf]=='ok') echo $moneda; else echo $lnkmoneda?></td>
		</tr>
		  <tr>
			<td colspan="3"><strong>FTE. FTO.-EJEC. : 
	        <?=$ReporteAAnpS->listar_ff_siglas($ffuente)?>  
		    </strong></td>
		</tr>
		</table>
	
	
			<table width="100%"  border="1" cellspacing="0" cellpadding="0" class="tab" bgcolor="#FFFFFF">
			  <tr bgcolor="#7B869C">
					<th class="th2" width="5%" rowspan="2" align="center">C&oacute;digo</th>
					<th class="th2" nowrap="nowrap" rowspan="2" align="center">Programas/Subprogramas/Actividades</th>
					<th colspan="<?=$numAnps?>" align="center" class="th2">ANP's</th>
					<th class="th2" width="5%" rowspan="2" align="center">TOTAL</th>
			  </tr>
				<tr bgcolor="#999999">
				<?
				for ($i=0;$i<$numAnps;$i++){ ?>
				 <th align="center" class="th2">
					 <? echo $Anps[$i]['siglas_anp']; ?>
				</th>
				<?
				}
				?>
				
			  </tr> 
			<? 
			$ReporteAAnpS->mostrar_AsignacionporSubactividades();
			
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
	$pdf->DisplayPreferences('HideWindowUI');
	
$pdf->AddPage();
$pdf->WriteHTML($htmlbuffer);
$pdf->Output('asig_anp_por_subact.pdf','D');}
?>