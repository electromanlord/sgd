<? if($_GET[pdf]=='ok'){
	require_once('../../pdf/html2fpdf.php');
	ob_start();
}
?><?
require("../libs/verificar.inc.php");
require("../../includes.php");
require("../cls/reporteinformaciongeneral.cls.php");

$link=new Conexion();
if ($_GET[pag]){ $pag=$_GET[pag];}
else{ $pag = 1;}
$tam_pag=20;	
$reg1 = ($pag-1) * $tam_pag;


//TIPO CAMBIO ANUAL
$sql="SELECT * FROM axo_poa where id_axo_poa='".$_SESSION[inrena_4][2]."'";
$Queryt= new Consulta($sql);
$tp=$Queryt->ConsultaVerRegistro();	
$tipo_cambio=$tp[tipo_cambio];
?>
<title>Reporte</title>
<link href="../../style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../../js/js.js"></script> 
<script language="javascript" src="../js/reporte.js"></script> 
<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
}
-->
</style><body topmargin="0">
<div id="barraBotones" name="barraBotones">
<?
if($_GET[pdf]!='ok'){ 
	///pdf
	$dir_pdf=$_SERVER['PHP_SELF'].'?ID='.$ID.'&pag='.$pag.'&pdf=ok';
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
$sql="SELECT nombre_tarea,medio_verificacion_tarea FROM tarea Order By nombre_tarea";
$queryPg=new Consulta($sql);
$row_res_pag=$queryPg->numregistros();

if($_GET[pdf]!='ok'){
	$fondo="";
	$sql=$sql." LIMIT $reg1,$tam_pag";
}
else $fondo="bgcolor='#EEEEEE'";
$query=new Consulta($sql);?>
<table border=0  width='85%' $fondo align=center cellspacing=1 cellpadding=2>
<tr>
  <th>Nombre Tarea </th><th>Unidad de Medida</th>
</tr>
<? while($row=$query->ConsultaVerRegistro()){?>
	<tr><td><?=$row[0]?></td><td><?=$row[1]?></td></tr>
<? }?>
</table>
<table border=0  width="85%" align=center cellspacing=1 cellpadding=2><tr>
<td colspan="10" align="center" bgcolor="#FFFFFF"><br>
<? if($_GET[pdf]!='ok') echo paginar($pag, $row_res_pag , $tam_pag, "tareas.php?ID=".$ID."&pag=");?>
</td></tr></table>
</body>
</html>
<? if($_GET[pdf]=='ok'){
$htmlbuffer=ob_get_contents();
	ob_end_clean();
	header("Content-type: application/pdf");
$pdf = new HTML2FPDF('P','mm','a4');
$pdf->ubic_css="../../style.css"; //agreg mio
	$pdf->DisplayPreferences('HideWindowUI');
	
$pdf->AddPage();
$pdf->WriteHTML($htmlbuffer);
$pdf->Output('reporte.pdf','D');}?>