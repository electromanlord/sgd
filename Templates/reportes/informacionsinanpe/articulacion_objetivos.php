<?php
if($_GET[pdf]=='ok'){
	require_once('../../pdf/html2fpdf.php');
	ob_start();
}
 
require_once("../../includes.php"); 
require_once("../funciones/reportes.php"); 
require("../libs/verificar.inc.php"); 
require("../cls/clases/class.objetivos_estrategicos.php");
require("../cls/clases/class.unidad_medida.php"); 
$link=new Conexion();
set_time_limit(100);

//if(!empty($_REQUEST['lista_anp'])) $anps=implode(',',$_REQUEST['lista_anp']);
if(!empty($_REQUEST['lista_ff'])) $ff=implode(',',$_REQUEST['lista_ff']);

$lnkmoneda="";
$md=$md;

if(empty($md)){
	$lnkmoneda='<a href="'.$_SERVER['PHP_SELF'].'?md=d&anps='.$anps.'&ff='.$ff.'"> Soles</a>';
	$cambio=1;
	$moneda="Soles";
}else{ 
	$lnkmoneda='<a href="'.$_SERVER['PHP_SELF'].'?anps='.$anps.'">D&oacute;lares</a>';
	$sql = "SELECT * FROM axo_poa where id_axo_poa='".$_SESSION[inrena_4][2]."'";
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
<?php
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
<table width="100%">			
	<tr>
		<td align="center">Plan Operativo Institucional <?=axo($_SESSION[inrena_4][2]) ?></td>
	</tr>
	<tr>
		<td align="center">Formato Nº 3 Articulacion de objetivos e Indicadores </td>
	</tr>
</table>
		
<hr width="100%">
<?php 
	
	if(!$ff) die("<div align='center' id='error'>No ha elegido ninguna Fuente de Financiamiento</div>");
	
	$siglas = array();
	$Qff = new Consulta("Select siglas_ff from fuente_financiamiento WHERE id_ff IN (".$ff.")"); 
		
	while($f_f = $Qff->ConsultaVerRegistro()) $siglas[] = $f_f[0];
	echo implode('/',$siglas);
	
	//saco los objetivos estrategicos
	$objetivos_estrategicos = new ObjetivosEstrategicos();
	$obj = $objetivos_estrategicos->getObjetivosEstrategicos();
	
	//filtro los presupuestos
	$sql_pff   = "SELECT * FROM presupuesto_ff WHERE id_ff in(".$ff.") ";
	$query_pff = new Consulta($sql_pff);
	$in_pff = "";
	while($row_pff = $query_pff->ConsultaVerRegistro()){		
		$in_pff .= $in_pff == "" ? $row_pff['id_presupuesto_ff'] : ",".$row_pff['id_presupuesto_ff'];		
	}
	
	//filtro los presupuestos
	$sql_p   = "SELECT * FROM presupuesto_anp WHERE id_presupuesto_ff in(".$in_pff.") ";
	$query_p = new Consulta($sql_p);
	$in_p = "";
	while($row_p = $query_p->ConsultaVerRegistro()){		
		$in_p .= $in_p == "" ? $row_p['id_presupuesto_anp'] : ",".$row_p['id_presupuesto_anp'];		
	}
	
	
	//  metodo que permite sacar los id_asignacion_anp_objetivos
	function asignacion_anp_objetivos($id_objetivo_estrategico){
		//OBJETIVO ESTRATEGICO				
		$sql_aae = " SELECT * FROM anp_objetivo_estrategico 
				WHERE id_objetivo_estrategico='".$id_objetivo_estrategico."'  ";
		$query_aae = new Consulta($sql_aae);
		$in_aae = "";
		while($row_aae = $query_aae->ConsultaVerRegistro()){
			$in_aae .=$in_aae == "" ? $row_aae['id_anp_objetivo_estrategico'] : ",".$row_aae['id_anp_objetivo_estrategico'];	
		}	
					
		//asignaciopn anp objetivos
		$sql_aao = "SELECT * FROM asignacion_anp_objetivos 
					WHERE id_anp_objetivo_estrategico in(".$in_aae.") 
					AND id_axo_poa='".$_SESSION[inrena_4][2]."' ";
						
		$query_aao = new Consulta($sql_aao);
		$in_aao="";
		while($row_aao = $query_aao->ConsultaVerRegistro()){
			$in_aao .=$in_aao == "" ? $row_aao['id_asignacion_anp_objetivos'] : ",".$row_aao['id_asignacion_anp_objetivos'];	
		}
		
		return $in_aao;
	
	}
	
	
	//metodo que permite calcular la cantidad de metas
	
	function calcula_metas($in_p, $in_aao, $trimestre = 0){
		
		$trimestres[1] = "1,2,3";
		$trimestres[2] = "4,5,6";
		$trimestres[3] = "7,8,9";
		$trimestres[4] = "10,11,12";
		
		
		$trim = $trimestre > 0 ? " AND mm.id_mes IN(".$trimestres[$trimestre].") " : ""  ; 
		
		$sql_afao = " SELECT sum(mm.cantidad_metas_meses) as total 
								FROM asignacion_ff_anp_objetivos afao, metas_meses mm 
								WHERE 	afao.id_asignacion_ff_anp_objetivos = mm.id_ff_anp_subactividad	AND
							  			id_presupuesto_anp in(".$in_p.") AND
							  			id_asignacion_anp_objetivos in(".$in_aao.")	".$trim."						  
							  	GROUP BY id_asignacion_ff_anp_objetivos";
		$query_afao = new Consulta($sql_afao);
		$total_metas = 0;
		
		while($row_afao = $query_afao->ConsultaVerRegistro()){
			$total_metas += $row_afao['total'];
		}
		
		return $total_metas;
	}
	
	
	//metodo que permite calcular los presupuestos
	function calcula_presupuesto($in_p, $in_aao, $trimestre = 0){
		
		$trimestres[1] = "1,2,3";
		$trimestres[2] = "4,5,6";
		$trimestres[3] = "7,8,9";
		$trimestres[4] = "10,11,12";		
		
		$trim = $trimestre > 0 ? " AND ppm.id_mes IN(".$trimestres[$trimestre].") " : ""  ; 
		
		$sql_afao = " 	SELECT sum(ppm.monto_programacion_partidas_meses) as total_presupuesto 
								FROM asignacion_ff_anp_objetivos afao, 
									programacion_partidas pp,
									programacion_partidas_meses ppm
								WHERE
							  afao.id_asignacion_ff_anp_objetivos = pp.id_ff_anp_subactividad AND
							  pp.id_programacion_partidas = ppm.id_programacion_partidas AND
							  id_presupuesto_anp in(".$in_p.") AND
							  id_asignacion_anp_objetivos in(".$in_aao.")	".$trim."						  
							  GROUP BY id_asignacion_ff_anp_objetivos";
				//echo $sql_afao;	  
				$query_afao = new Consulta($sql_afao);
				$total_presupuesto = 0;
				while($row_afao = $query_afao->ConsultaVerRegistro()){
					$total_presupuesto += $row_afao['total_presupuesto'];
				}
				
			return 	$total_presupuesto;
	}
	
		
?>	
<table width="100%" cellpadding="1" cellspacing="1" id="report">
  <tr bgcolor="#FFFFFF">
    <td colspan="2" align="center">Objetivos de Corto Plazo</td>
    <td colspan="13" align="center">Indicador</td>
    <td rowspan="4">Numero de Beneficiarios</td>
    <td rowspan="4">Ejes Estrategicos</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td rowspan="3">Objetivo General </td>
    <td rowspan="3">Objetivos Especificos </td>
    <td rowspan="3">Denominacion</td>
    <td rowspan="3">Unidad de Medida </td>
    <td rowspan="3">Linea de Base </td>
    <td rowspan="3">Meta Fisica Anual </td>
    <td rowspan="3">Presupuesto Anual </td>
    <td colspan="8" align="center">Programaci&oacute;n Trimestral </td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td colspan="2">I Trimestre </td>
    <td colspan="2">II Trimestre</td>
    <td colspan="2">III Trimestre</td>
    <td colspan="2">IV Trimestre</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>Fisica</td>
    <td>Presupuesto</td>
    <td>Fisica</td>
    <td>Presupuesto</td>
    <td>Fisica</td>
    <td>Presupuesto</td>
    <td>Fisica</td>
    <td>Presupuesto</td>
  </tr>
  <tr bgcolor="#FFFFFF">
  	<td>Conservacion y aprovechamiento sostenible de los recursos naturales</td>
	<td>Manejo eficiente de las areas naturales protegidas para la conservacion de la diversidad biologica</td>
	<td valign="top">	
		<table width="100%" id="subreport" > <?php 
			for($x=0; $x < count($obj); $x++){	?>
				<tr bgcolor="#FFFFFF"><td><?php echo $obj[$x]['indicador']; ?></td></tr><?php 
			} ?>
		</table>	
	</td>
	<td valign="top">
		<table width="100%" id="subreport" > <?php 
			for($x=0; $x < count($obj); $x++){	?>
				<tr bgcolor="#FFFFFF"><td><?php echo $obj[$x]['unidad_medida'];?></td></tr><?php 
			} ?>
		</table>
	</td>
	<td>
		
	</td>
	<td valign="top">
		<table width="100%" id="subreport" > <?php  //META FISICA ANUAL
		
			for($x=0; $x < count($obj); $x++){
				
				//obtebemos los id asignacion_anp_objetivos 
				$in_aao = asignacion_anp_objetivos($obj[$x]['id']);		
						
				//cantidad metas
				$total_metas = calcula_metas($in_p, $in_aao)  ?>
								
				<tr bgcolor="#FFFFFF"><td align="right"><?php echo $total_metas; ?></td></tr><?php 
			} ?>
		</table>
	</td>
	<td valign="top">
		<table width="100%" id="subreport"> <?php  	//PRESUPUESTO ANUAL 
		
			for($x=0; $x < count($obj); $x++){
				
				//obtebemos los asignacion_anp_objetivos
				$in_aao = asignacion_anp_objetivos($obj[$x]['id']);				
						
				//PRESUPUESTO ANUAL
				$total_presupuesto = calcula_presupuesto($in_p, $in_aao);	 ?>				
				
				<tr bgcolor="#FFFFFF"><td align="right"><?php echo number_format($total_presupuesto,2); ?></td></tr><?php 
			} ?>
		</table>	
	</td>
	<td valign="top">
		<table width="100%" id="subreport" > <?php  //META FISICA TRIMESTRAL I
		
			for($x=0; $x < count($obj); $x++){
				
				//obtebemos los id asignacion_anp_objetivos 
				$in_aao = asignacion_anp_objetivos($obj[$x]['id']);		
						
				//cantidad metas
				$total_metas = calcula_metas($in_p, $in_aao, 1)  ?>
								
				<tr bgcolor="#FFFFFF"><td align="right"><?php echo $total_metas; ?></td></tr><?php 
			} ?>
		</table></td>
	<td valign="top">
		<table width="100%" id="subreport"> <?php  	//PRESUPUESTO TRIMESTRAL I 
		
			for($x=0; $x < count($obj); $x++){
				
				//obtebemos los asignacion_anp_objetivos
				$in_aao = asignacion_anp_objetivos($obj[$x]['id']);				
						
				//PRESUPUESTO ANUAL
				$total_presupuesto = calcula_presupuesto($in_p, $in_aao, 1);	 ?>				
				
				<tr bgcolor="#FFFFFF"><td align="right"><?php echo number_format($total_presupuesto,2); ?></td></tr><?php 
			} ?>
		</table>
	</td>
	<td valign="top">
		<table width="100%" id="subreport" > <?php  //META FISICA TRIMESTRAL II
		
			for($x=0; $x < count($obj); $x++){
				
				//obtebemos los id asignacion_anp_objetivos 
				$in_aao = asignacion_anp_objetivos($obj[$x]['id']);		
						
				//cantidad metas
				$total_metas = calcula_metas($in_p, $in_aao, 2)  ?>
								
				<tr bgcolor="#FFFFFF"><td align="right"><?php echo $total_metas; ?></td></tr><?php 
			} ?>
		</table></td>
	<td valign="top">
		<table width="100%" id="subreport"> <?php  	//PRESUPUESTO TRIMESTRAL II 
		
			for($x=0; $x < count($obj); $x++){
				
				//obtebemos los asignacion_anp_objetivos
				$in_aao = asignacion_anp_objetivos($obj[$x]['id']);				
						
				//PRESUPUESTO ANUAL
				$total_presupuesto = calcula_presupuesto($in_p, $in_aao, 2);	 ?>				
				
				<tr bgcolor="#FFFFFF"><td align="right"><?php echo number_format($total_presupuesto,2); ?></td></tr><?php 
			} ?>
		</table>
	</td>
	<td valign="top">
		<table width="100%" id="subreport" > <?php  //META FISICA TRIMESTRAL III
		
			for($x=0; $x < count($obj); $x++){
				
				//obtebemos los id asignacion_anp_objetivos 
				$in_aao = asignacion_anp_objetivos($obj[$x]['id']);		
						
				//cantidad metas
				$total_metas = calcula_metas($in_p, $in_aao, 3)  ?>
								
				<tr bgcolor="#FFFFFF"><td align="right"><?php echo $total_metas; ?></td></tr><?php 
			} ?>
		</table></td>
	<td valign="top">
		<table width="100%" id="subreport"> <?php  	//PRESUPUESTO TRIMESTRAL III
		
			for($x=0; $x < count($obj); $x++){
				
				//obtebemos los asignacion_anp_objetivos
				$in_aao = asignacion_anp_objetivos($obj[$x]['id']);				
						
				//PRESUPUESTO ANUAL
				$total_presupuesto = calcula_presupuesto($in_p, $in_aao, 3);	 ?>				
				
				<tr bgcolor="#FFFFFF"><td align="right"><?php echo number_format($total_presupuesto,2); ?></td></tr><?php 
			} ?>
		</table>
	</td>
	<td valign="top">
		<table width="100%" id="subreport" > <?php  //META FISICA TRIMESTRAL IV
		
			for($x=0; $x < count($obj); $x++){
				
				//obtebemos los id asignacion_anp_objetivos 
				$in_aao = asignacion_anp_objetivos($obj[$x]['id']);		
						
				//cantidad metas
				$total_metas = calcula_metas($in_p, $in_aao, 4)  ?>
								
				<tr bgcolor="#FFFFFF"><td align="right"><?php echo $total_metas; ?></td></tr><?php 
			} ?>
		</table></td>
	<td valign="top">
		<table width="100%" id="subreport"> <?php  	//PRESUPUESTO TRIMESTRAL IV 
		
			for($x=0; $x < count($obj); $x++){
				
				//obtebemos los asignacion_anp_objetivos
				$in_aao = asignacion_anp_objetivos($obj[$x]['id']);				
						
				//PRESUPUESTO ANUAL
				$total_presupuesto = calcula_presupuesto($in_p, $in_aao, 4);	 ?>				
				
				<tr bgcolor="#FFFFFF"><td align="right"><?php echo number_format($total_presupuesto,2); ?></td></tr><?php 
			} ?>
		</table>
	</td>
	<td></td>
	<td></td>  
  </tr>
</table>
<script language="javascript">
FullScreen();
</script>
</body>
</html>
<?php 
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