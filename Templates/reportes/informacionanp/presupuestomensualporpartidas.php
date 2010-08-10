<?
//session_start();
if($_GET[pdf]=='ok'){
	require_once('../../pdf/html2fpdf.php');
	ob_start();
}
?><?
require_once("../../includes.php"); 
require_once("../funciones/reportes_meses.php");
require_once("../cls/informacionanp/presupuestomensualporpartidas.cls.php");
require("../libs/verificar.inc.php"); 
set_time_limit(100);
$link=new Conexion();

					

$ReportePMPP=new PresupuestoMensualPorPartidas();
$ReportePMPP->$anpid=$id;
//echo ($id);

$lnkmoneda="";
$md=$md;
if(empty($md)){ //(esta en soles)
	$lnkmoneda='<a href="'.$_SERVER['PHP_SELF']."?id=".$id."&md="."d".'">Soles</a>';
	$mnd="Soles";
}else{ // (esta en Dolar)
	$lnkmoneda='<a href="'.$_SERVER['PHP_SELF']."?id=".$id.'">Dolares</a>';
	$ReportePMPP->md=true;
	$ReportePMPP->simbolomd=" $ ";
	$mnd="Dólares";
}

if ($_POST){

$_SESSION[inrena_4][ffuente]="";
	for ($i=0;$i<count($_POST[S2]);$i++){
		$_SESSION[inrena_4][ffuente][]=$_POST[S2][$i];
	}
}else{ echo"No hay datos";}

echo $_POST[S2];

$ffuente=$_SESSION[inrena_4][ffuente];

echo $ffuente;
 
$ReportePMPP->ftefto=$ffuente;

$Apartidas=$ReportePMPP->ListarPartidas();


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
<?		
$sql="select m.nombre_mes from mes m where m.id_mes='".$_SESSION[idmes]."'";$rowm=new Consulta($sql);while($row=$rowm->ConsultaVerRegistro()){?>
		<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
		  <tr>	<th align=center class="tit" ><p>Partidas por Tareas - POA   
	        <?=axo($_SESSION[inrena_4][2]) ?>
	        <?="-"?>
            <?=$row['nombre_mes']?>
		    </p>
		    <p><strong>
		      <?=anp($_SESSION['anp']['anpid'])?>
		    </strong></p>
		    </th>  
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
			<td colspan="3"><strong>FTE. FTO.-EJEC.: <?=$ReportePMPP->listar_ff_siglas($ffuente)?>  
	        
		    </strong></td>
		</tr>
		</table>
	
<? }?>
			<table width="100%"  border="1" cellspacing="0" cellpadding="0" class="tab">
			  <tr>
					<th class="th2" width="5%" rowspan="2" align="center">C&oacute;digo</th>
					<th class="th2" width="24%" rowspan="2" align="center">Tareas</th>
					<th colspan="<?=count($Apartidas)?>" width="60%" align="center" class="th2">PARTIDAS</th>
					<th class="th2" width="8%" rowspan="2" align="center">TOTAL</th>
			  </tr>
				<tr >
				  <? 
				  for ($i=0;$i<count($Apartidas); $i++){ ?>
			    <th align="center" class="th2">
				<?=$Apartidas[$i][codigo_partida]?>
				</th>
							<? }  ?>
			  </tr> 
			  
			<?
			$ReportePMPP->mostrar_Presupuesto_tarea($ffuente);
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
	//header("Content-type: application/pdf");
$pdf = new HTML2FPDF('P','mm','a4x');
$pdf->ubic_css="../../style.css"; //agreg mio
$pdf->AddPage();
$pdf->WriteHTML($htmlbuffer);
$pdf->Output('reporte.pdf','D');}
?>