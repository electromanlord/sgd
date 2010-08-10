<?
if($_GET[pdf]=='ok'){
	require_once('../../pdf/html2fpdf.php');
	ob_start();
}
?>
<?
require_once("../../includes.php"); 
require_once("../funciones/reportes.php"); 
require_once("../cls/informacionanp/objetivosestrategicos.cls.php");
require("../libs/verificar.inc.php"); 
set_time_limit(100);
$link=new Conexion();

$ReporteOE=new ObjetivosEstrategicos();
$ReporteOE->anpid=$id;

$lnkmoneda="";
$md=$md;
if(empty($md)){
	$lnkmoneda='<a href="'.$_SERVER['PHP_SELF']."?id=".$id."&md="."d".'">Soles</a>';
	$tp_mon='Soles';
}else{
	$lnkmoneda='<a href="'.$_SERVER['PHP_SELF']."?id=".$id.'">Dolares</a>';
	$ReporteOE->md=true;
	$tp_mon='Dolares';
	$ReporteOE->simbolomd=" $ ";
}

if ($_POST){
$_SESSION[inrena_4][ffuente]="";
	for ($i=0;$i<count($_POST[S2]);$i++){
		$_SESSION[inrena_4][ffuente][]=$_POST[S2][$i];
	}
}

$ffuente=$_SESSION[inrena_4][ffuente];
$ReporteOE->ftefto=$ffuente;

$Fts=$ReporteOE->ListarFts();
$numFts=count($Fts);


?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Objetivos Estrat&eacute;gicos</title>
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
        <td align="center" class="tit" ><p>Objetivos Estrat&eacute;gicos </p>
        <p><b>
           <? $row_nom="select * from anp where anp.id_anp='".$id."'";
			 $querynom=new Consulta($row_nom);
			 $row=$querynom->ConsultaVerRegistro();	
			 echo $row[3] ; ?>
        </b></p></td>
      </tr>
    </table>
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="2%">&nbsp;</td>
          
          <td >&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"><b>FTE. FTO.-EJEC::
            <?=$ReporteOE->listar_ff_siglas($ffuente)?>
          </b></td>
          <td align="right"><? if($_GET[pdf]!='ok') echo $lnkmoneda; else echo $tp_mon; ?> </td>
        </tr>
</table>
      <table border="1" align="center" cellpadding="0" cellspacing="0" class="tab">
        <tr>
          <th nowrap rowspan="2" width="6%" align="center" class="th2">Codigo</th>
          <th nowrap rowspan="2" width="22%" align="center" class="th2">Obj. Estrategico/ Obj. Especifico/ Tareas</th>
		  <th nowrap rowspan="2" class="th2" align="center">Resultados Esperados</th>
          <th nowrap width="5%" rowspan="2" align="center" class="th2" >Unidad de Medida</th>
          <th class="th2" colspan="2" align="center">META <?= axo($_SESSION[inrena_4][2]) ?></th>
          <th colspan="<?=$numFts?>" align="center" class="th2">Fuente  Financ. - Ejecutor</th>
        </tr>
		<tr>
          <th align="center" width="5%" class="th2">F&iacute;sica</th>
          <th align="center" width="7%"class="th2">Financiera</th>
		   	<?
		  	for ($i=0;$i<$numFts;$i++){
		 	 ?>
			  <th class="th2" align="center" width="7%">
		  	<?=$Fts[$i]['siglas_ff']?>
 			</th>
			<? }?>
	 </tr>
	 	<?
		$ReporteOE->mostrar_objetivosestrategicos($id,$_SESSION[inrena_4][2]);
		?>
</table>
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
//$pdf->SetFont('Arial','',12);
  // $pdf->setBasePath("../../../");
$pdf->WriteHTML($htmlbuffer);
$pdf->Output('reporte.pdf','D');}?>