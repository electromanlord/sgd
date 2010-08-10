<?
if($_GET[pdf]=='ok'){
	require_once('../../pdf/html2fpdf.php');
	ob_start();
}
?><?
//session_start();
require_once("../../includes.php"); 
require_once("../funciones/reportes.php"); 
require_once("../cls/fisicofinanciero.php");
require_once("../libs/verificar.inc.php"); 
///$_SESSION["anp"]["idanp"]=$anpid;
$link=new Conexion();
set_time_limit(100);
$ReporteFF=new FisicoFinanciero();
$ReporteFF->anpid=$id;

$lnkmoneda="";
$md=$md;
if(empty($md)){ //(esta en soles)
	$lnkmoneda='<a href="'.$_SERVER['PHP_SELF']."?id=".$id."&md="."d".'">Soles</a>';
	$moneda="Soles";
}else{ // (esta en Dolar)
	$lnkmoneda='<a href="'.$_SERVER['PHP_SELF']."?id=".$id.'">Dolares</a>';
	$ReporteFF->md=true;
	$moneda="Dolares";
	$ReporteFF->simbolomd=" $ ";
}

if ($_POST){
$_SESSION[inrena_4][ffuente]="";
	for ($i=0;$i<count($_POST[S2]);$i++){
		$_SESSION[inrena_4][ffuente][]=$_POST[S2][$i];
	}
}

$ffuente=$_SESSION[inrena_4][ffuente];
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
<div align="center" class="header" style="font-size:16px;"><? $row_nom="select * from anp where anp.id_anp='".$id."'";
			 $querynom=new Consulta($row_nom);
			 $row=$querynom->ConsultaVerRegistro();	
			 echo $row[3] ; ?>
</div>
<form name="form1" method="post" action="">
   <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center" bgcolor="#006666"><strong style="font-size:14px; color:#FFFFFF">F&Iacute;SICO FINANCIERO - POA 
              <?= axo($_SESSION[inrena_4][2]) ?>
            </strong></td>
     </tr>
  </table>
          <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#006666" 
		  >
            <tr>
              <td align=center><font size=3>&nbsp;</font></td>
              <td width=2% align="right"> </td>
            </tr>
          </table>
       
<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
            <tr>
              <td width="13%" nowrap><?
	$anp=anp($ReporteFF->anpid);
	$fuente_siglas=$ReporteFF->listar_ff_siglas($ffuente);
	?></td>
              <td width="81%">&nbsp;</td>
              <td width="6%" nowrap>&nbsp;</td>
            </tr>
          </table>
        <table width="100%"  border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
            <tr>
              <td width="1%">&nbsp;</td>
              <td width="24%" nowrap>&nbsp;</td>
              <td width="74%">&nbsp;</td>
              <td width="1%" nowrap><? if($_GET[pdf]=='ok') echo $moneda; else echo $lnkmoneda?></td>
            </tr>
            <tr>
              <td colspan="4"><b>FTE.FTO.-EJEC.:
                <?=$fuente_siglas?></td>
            </tr>
          </table>
        <?
		$ReporteFF->mostrar_fisico_financiero($ffuente);
	?>
</form>
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
$pdf->Output('fisico_financiero.pdf','D');}
?>