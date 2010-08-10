<?
if($_GET[pdf]=='ok'){
	require_once('../../pdf/html2fpdf.php');
	ob_start();
}
?><?
require_once("../../includes.php"); 
require_once("../funciones/reportes.php"); 
require("../libs/verificar.inc.php"); 
$link=new Conexion();
set_time_limit(100);

if(!empty($_REQUEST['lista_anp'])) $anps=implode(',',$_REQUEST['lista_anp']);

$lnkmoneda="";
$md=$md;

if(empty($md)){
	$lnkmoneda='<a href="'.$_SERVER['PHP_SELF'].'?md=d&anps='.$anps.'"> Soles</a>';
	$cambio=1;
	$moneda="Soles";
}else{ 
	$lnkmoneda='<a href="'.$_SERVER['PHP_SELF'].'?anps='.$anps.'">D&oacute;lares</a>';
	$sql="SELECT * FROM axo_poa where id_axo_poa='".$_SESSION[inrena_4][2]."'";
	$Queryt= new Consulta($sql);
    $rowt=$Queryt->ConsultaVerRegistro();	
	$cambio=$rowt[tipo_cambio];
	$moneda="Dolares";
}

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
	$dir_pdf=$_SERVER['PHP_SELF'].'?id='.$id.'&md='.$md.'&mes='.$mes.'&pdf=ok';
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
		  <tr>	<th align='center' class="tit" bgcolor="#999999" >Asignacion de Tareas por ANP </th>  
		  </tr>
</table>
<hr width="100%">
<table width="600" border="0" cellpadding="2" cellspacing="0" bgcolor="#FFFFFF">

</table>
<table width="100%" align="center"  border="0" cellpadding="2" cellspacing="0" bgcolor="#FFFFFF">
<tr><td align="right" colspan="4">
<font size="-1"><? if($_GET[pdf]=='ok') echo $moneda; else echo $lnkmoneda?>&nbsp;&nbsp;</font>
</td></tr></table>  
<table border="0" width="100%" cellspacing="0" cellpadding="0" class="tab" align="center" bgcolor="#FFFFFF">
<tr><th >Tarea</th>
<? 	$ord_anp=array();
	$sql="SELECT anp.siglas_anp,anp.id_anp FROM anp Inner Join categoria ON anp.id_categoria = categoria.id_categoria
			WHERE anp.id_anp IN (".$anps.") ORDER BY anp.id_anp";
 	$Q= new Consulta($sql);	
	while($row=$Q->ConsultaVerRegistro()){
		echo "<th align='right'>".$row[0]."</th>";			
		$ord_anp[]=$row[1];
	}
?>
</tr>
<? 	$obj=new SqlSelect('',$_SESSION["inrena_4"][2],$_SESSION["inrena_4"][1]);
	$sql=$obj->set_sql(" nombre_tarea,t.id_tarea "," AND pa.id_anp IN (".$anps.")",
							" t.id_tarea"," t.nombre_tarea");
	$Qtarea=new Consulta($sql);				
	while($rowt=$Qtarea->ConsultaVerRegistro()){
		echo "<tr><td width='200'>".$rowt[0]."</td>";	
		foreach($ord_anp as $array_anp){
			$sql_m="SELECT sum(afao.monto_asignacion_ff_anp_objetivos)/$cambio
				FROM asignacion_ff_anp_objetivos AS afao 
					Inner Join asignacion_anp_objetivos aao 
						ON aao.id_asignacion_anp_objetivos = afao.id_asignacion_anp_objetivos
					Inner Join presupuesto_anp as pa ON pa.id_presupuesto_anp = afao.id_presupuesto_anp 
					Inner Join presupuesto_ff as pf ON pf.id_presupuesto_ff = pa.id_presupuesto_ff
					Inner Join fuente_financiamiento as ff ON ff.id_ff = pf.id_ff 
					Inner Join anp_objetivo_especifico aoesp 
						ON aoesp.id_anp_objetivo_especifico = aao.id_anp_objetivo_especifico 
					Inner Join tarea as t ON t.id_tarea = aao.id_tarea 
					Inner Join anp_objetivo_estrategico aoest 
							ON aoest.id_anp_objetivo_estrategico = aoesp.id_anp_objetivo_estrategico 
					Inner Join objetivo_estrategico oe ON oe.id_objetivo_estrategico = aoest.id_objetivo_estrategico 
					Inner Join anp a ON pa.id_anp = a.id_anp
					Inner Join categoria ctg ON a.id_categoria=ctg.id_categoria 
				WHERE pf.id_axo_poa = '".$_SESSION["inrena_4"][2]."' AND t.id_tarea='".$rowt[1]."' AND pa.id_anp=$array_anp ". 
					permisos_fuente($_SESSION['inrena_4'][1]).
				" GROUP BY a.id_anp ORDER BY a.id_anp";
		//die($sql_m);
			$Qm=new Consulta($sql_m);
			$monto=$Qm->ConsultaVerRegistro();
			if($monto[0]>0) echo "<td align='right'>".number_format($monto[0],2,".",",")."</td>";
			else echo "<td align='right'>&nbsp;</td>";
		}
		echo "</tr>";
	}	
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
$pdf->Output('tareas_por_anp.pdf','D');}
?>