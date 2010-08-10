<?
session_start();
if($_GET[pdf]=='ok'){
	require_once('../../pdf/html2fpdf.php');
	ob_start();
}
?><?
require_once("../../includes.php"); 
require_once("../funciones/reportes.php"); 
require_once("../cls/informacionanp/prepuestotrimestral.cls.php");
require("../libs/verificar.inc.php"); 
set_time_limit(100);
$link=new Conexion();

$ReportePT=new PresupuestoTrimestral();
$ReportePT->anpid=$id;

$lnkmoneda="";
$md=$md;
if(empty($md)){
	$lnkmoneda='<a href="'.$_SERVER['PHP_SELF']."?id=".$id."&md="."d".'">Soles</a>';
	$mnd="Soles";
}else{
	$lnkmoneda='<a href="'.$_SERVER['PHP_SELF']."?id=".$id.'">Dolares</a>';
	$ReportePT->md=true;
	$ReportePT->simbolomd=" $ ";
	$mnd="Dólares";
}

if ($_POST){
$_SESSION[inrena_4][ffuente]="";
	for ($i=0;$i<count($_POST[S2]);$i++){
		$_SESSION[inrena_4][ffuente][]=$_POST[S2][$i];
	}
}

$ffuente=$_SESSION[inrena_4][ffuente];
$idff=$_GET[idff];
if (empty($idff)){
$idff=$ffuente[0];
}else{
die ("no hay fuente seleccionadas");
}
//echo "<br>".$idff."<br>";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Presupuesto Trimestral</title>
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

<body>
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
      <tr>
        <th align=center class="tit" ><p><strong>Presupuesto Trimestral - POA 
          <?=axo($_SESSION[inrena_4][2]) ?>
        </strong></p>
          <p><b>
            <? $row_nom="select * from anp where anp.id_anp='".$id."'";
			 $querynom=new Consulta($row_nom);
			 $row=$querynom->ConsultaVerRegistro();	
			 echo $row[3] ; ?>
          </b></p></th>
      </tr>
    </table>
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="3%">&nbsp;</td>
          <td width="80%">&nbsp;</td>
          <td width="" align="right"><? if($_GET[pdf]!='ok') echo $lnkmoneda; else echo $mnd;?></td>
        </tr>
        <tr>
          <td colspan="2"><b>FTE. FTO.-EJEC. :
            <?=$ReportePT->listar_ff_siglas($ffuente)?>
          </b></td>
          <td align="right">&nbsp;</td>
        </tr>
      </table>
	  <? $medT='100%'; if($_GET[pdf]=='ok') $medT='800'; ?> 
      <table width="<?=$medT?>"  border="1" cellpadding="0" cellspacing="0" class="tab" >
        <tr>
          <th class="th2" width="5%" rowspan="2" align="center">C&oacute;digo</th>
          <th rowspan="2" width="17%" align="center" class="th2" nowrap="nowrap">Obj. Estrategico/ Obj. Especifico/ Tareas</th>
          <th class="th2" colspan="3" align="center" >Programaci&oacute;n Anual</th>
          <th class="th2" colspan="2" align="center" >I Trimestre</th>
          <th class="th2" colspan="2" align="center" >II Trimestre</th>
          <th class="th2" colspan="2" align="center" >III Trimestre</th>
          <th class="th2" colspan="2" align="center" >IV Trimestre</th>
        </tr>
		
        <tr>
          <th align="center" class="th2" width="5%" nowrap >Unidad de Medida</th>
          <th class="th2" width="4.5%" align="center">F&iacute;sica</th>
          <th class="th2" width="6.5%" align="center">Financiera</th>
          <th class="th2" width="4.5%" align="center">F&iacute;sica</th>
          <th class="th2" width="6.5%" align="center">Financiera</th>
		  <th class="th2" width="4.5%" align="center">F&iacute;sica</th>
          <th class="th2" width="6.5%" align="center">Financiera</th>
		  <th class="th2" width="4.5%" align="center">F&iacute;sica</th>
          <th class="th2" width="6.5%" align="center">Financiera</th>
		  <th class="th2" width="4.5%" align="center">F&iacute;sica</th>
          <th class="th2" width="6.5%" align="center">Financiera</th>
        </tr>
		<?
		$ReportePT->mostrar_PresupuestoMensual($ffuente);
		?>
      </table>
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
$pdf->SetFont('Arial','',12);
  // $pdf->setBasePath("../../../");
$pdf->WriteHTML($htmlbuffer);
$pdf->Output('reporte.pdf','D');}
?>