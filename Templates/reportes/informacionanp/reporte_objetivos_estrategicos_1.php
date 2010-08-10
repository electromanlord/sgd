<? if($_GET[pdf]=='ok'){
	require_once('../../pdf/html2fpdf.php');
	ob_start();
}
?><?
require("../libs/verificar.inc.php");
require("../../includes.php");
require("../cls/reporteinformaciongeneral.cls.php");

$link=new Conexion();
if ($pag){ $pag=$_GET[pag];}
else{ $pag = 1;}
$tam_pag=20;	
$reg1 = ($pag-1) * $tam_pag;

$sql="SELECT cargo_anp.nombre_cargo_anp FROM cargo_anp ORDER BY nro_orden";
$queryPg=new Consulta($sql);
$row_res_pag=$queryPg->numregistros();

//TIPO CAMBIO ANUAL
$sql_axo="SELECT * FROM axo_poa where id_axo_poa='".$_SESSION[inrena_4][2]."'";
$Queryt= new Consulta($sql_axo);
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
<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <th align=center class="tit" ><strong>Objetivos Estrat&eacute;gicos
          <?=axo($_SESSION[inrena_4][2]) ?> - <?=anp($_SESSION['anp']['idanp'])?></strong></th>
      </tr>
    </table><br>
<?
if($_GET[pdf]!='ok'){
	$fondo="";
	$sql=$sql." LIMIT $reg1,$tam_pag";
}
else $fondo="bgcolor='#EEEEEE'";
			

$sql = "SELECT * FROM anp_objetivo_estrategico aoe,objetivo_estrategico oe, anp_objetivo_estrategico_meta m 
			WHERE aoe.id_objetivo_estrategico=oe.id_objetivo_estrategico 
				AND m.id_anp_objetivo_estrategico=aoe.id_anp_objetivo_estrategico
				AND id_anp='".$_SESSION['anp']['idanp']."' AND id_axo_poa='".$_SESSION['inrena_4']['2']."'
				AND id_quinquenio='".axo_quinq($_SESSION['inrena_4']['2'],'','id')."'
			ORDER BY codigo_objetivo_estrategico  ";					
$Q= new Consulta($sql);		
?>
<table border=0 align='center' bgcolor='#FFFFFF' id=listado width='90%' >	
<tr>
<td class=subtitulo>Codigo</td><td class=subtitulo>Objetivo Estratégico</td>
<td class=subtitulo>Indicador</td>
	<td class=subtitulo>Unidad de Medida</td>
	<td class=subtitulo>Meta</td></tr>
<?
while ($row=$Q->ConsultaVerRegistro()){ $id=$row[id_anp_objetivo_estrategico];?>
<tr class='reg2'>
	<td><?=$row[codigo_objetivo_estrategico]?></td>
	<td align="left"><?=$row[nombre_objetivo_estrategico]?></td>
	<td align="left"><?=$row[indicador_objetivo_estrategico]?></td>
	<td align="center"><?=$row[id_unidad_medida]?></td>
	<td align="right"><?=$row[meta_anp_objetivo_estrategico]?></td>
</tr><tr><td colspan="6">
<? $sql_="SELECT * FROM anp_objetivo_especifico aoe, anp_objetivo_especifico_meta m 
				WHERE id_anp_objetivo_estrategico='".$id."' AND id_axo_poa='".$_SESSION['inrena_4']['2']."'
					AND m.id_anp_objetivo_especifico=aoe.id_anp_objetivo_especifico
				ORDER BY codigo_objetivo_especifico  ";					
		$Q_= new Consulta($sql_);	
		while ($r=$Q_->ConsultaVerRegistro()){ $ids=$r[id_anp_objetivo_especifico];?>
			<tr class='reg1'>
			<td><?=$row[codigo_objetivo_estrategico].".".
					$r[codigo_objetivo_especifico]?></td>
			<td align="left"><?=$r[nombre_objetivo_especifico]?></td>
			<td align="left"><?=$r[indicador_objetivo_especifico]?></td>
			<td align="center"><?=$r[unidad_medida]?></td>
			<td align="right"><?=$r[meta_anp_objetivo_especifico]?></td>
			</tr>
	<? }?>
<? } ?>
</table>
<script language="javascript">
FullScreen();
</script>
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