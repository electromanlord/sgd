<?
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
$ReportePMPP->$_SESSION['anp']['idanp']=$id;


$lnkmoneda="";
$md=md;
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
	for ($i=0;$i<count($_GET[S2]);$i++){
		$_SESSION[inrena_4][ffuente][]=$_GET[S2][$i];
	}
}

$ffuente=$_SESSION[inrena_4][ffuente];


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
.Estilo3 {font-size: xx-small}
.Estilo4 {font-size: 9px}
.Estilo5 {font-size: 12px}
-->
</style></head>
<body class="Estilo3" >
<div class="Estilo3" id="barraBotones" name="barraBotones">
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
$sql="select m.nombre_mes from mes m where m.id_mes='".$_POST[idmes]."'";$rowm=new Consulta($sql);while($row=$rowm->ConsultaVerRegistro()){?>

<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>	<th align=center ><p class="Estilo5"><strong>Partidas por Tareas - POA   
        <?=axo($_SESSION[inrena_4][2]) ?>
        <?="-"?>
        <?=$row['nombre_mes']?>
  </p>
      <p class="Estilo5"><strong>
        <?=anp($ReportePMPP->anpid)?>
      </strong></p></th>  
  </tr>
  </table> 

<? }?>

<hr width="100%">
		<table width="100%"  border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="15" nowrap class="Estilo3">&nbsp;</td>
			<td width="80%">&nbsp;</td>
			<td width="" align="right" class="Estilo3"><? if($_GET[pdf]!='ok') echo $lnkmoneda; else echo $mnd;?></td>
		</tr>
		  <tr>
			<td colspan="3" class="Estilo3"><strong><span class="Estilo4">FTE. FTO.-EJEC.:</span> 
	        <?=$ReportePMPP->listar_ff_siglas($ffuente);?>  
		    </strong></td>
		</tr>
		</table>
	
	
			<table width="100%"  border="1" cellspacing="0" cellpadding="0" class="tab">
			  <tr>
					<th width="5%" rowspan="2" align="center" class="th2 Estilo4">C&oacute;digo</th>
					<th width="24%" rowspan="2" align="center" class="th2 Estilo4">Tareas</th>
					<th width="60%" colspan="<?=count($Apartidas)?>" align="center" class="th2 Estilo4">PARTIDAS</th>
					<th width="8%" rowspan="2" align="center" class="th2 Estilo4">TOTAL</th>
			  </tr>
				<tr >
				  <? 
				  for ($i=0;$i<count($Apartidas); $i++){ ?>
			    <th align="center" class="th2  Estilo3">
				  <span class="Estilo4">
				  <?=$Apartidas[$i][codigo_partida]?>
				  </span> </th>
							<? }  ?>
			  </tr> 
			  
			<?
			$ReportePMPP->mostrar_Presupuesto($ffuente);
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
$pdf->Output('reporte.pdf','D');
}
?>