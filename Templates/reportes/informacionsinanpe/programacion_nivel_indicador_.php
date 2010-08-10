<?
require_once("../../includes.php"); 
require_once("../funciones/reportes.php"); 
require("../libs/verificar.inc.php"); 


//require_once("../../formulacion/cls/programacion_tareas.cls.php");
$link=new Conexion();
set_time_limit(100);

if($_POST['idanp']) $anp=$_POST['idanp'];
if($_GET[idanp]) $anp=$_GET[idanp];


$sql_anp="SELECT a.*, c.nombre_categoria, d.nombre_departamento FROM `anp` AS `a`
Inner Join `categoria` AS `c` ON `c`.`id_categoria` = `a`.`id_categoria`
Inner Join `ubicacion` AS `u` ON `u`.`id_anp` = `a`.`id_anp`
Inner Join `departamento` AS `d` ON `d`.`id_departamento` = `u`.`id_departamento`
WHERE `a`.`id_anp` =  '".$anp."' group by a.id_anp";
$Q_anp= new Consulta($sql_anp);
$row_anp=$Q_anp->ConsultaVerRegistro();	


$lnkmoneda="";
$md=$md;

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Reporte</title>
<link rel="stylesheet" type="text/css" href="../../style.css">
<script language="javascript" src="../../js/js.js"></script> 
<script language="javascript" src="../js/reporte.js"></script>
<style type="text/css">

body {
	background-color: #FFFFFF;
}

</style></head>
<body >

<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF">
		  <tr>	
		  <th align='center' class="tit" bgcolor="#999999" >Plan Operativo Institucional&nbsp;<?=axo($_SESSION["inrena_4"][2])?>  </th>  
		  </tr>
		  <tr><td align="center">Formato Nº4 </td></tr>
		  <tr>
		    <td align="center">Ficha: Programacion al Nivel de Indicador</td>
		  </tr>
</table>
<br>
<?		$quin=axo_quinq($_SESSION["inrena_4"][2]);	
		$sql="SELECT * FROM anp_objetivo_estrategico aoe,objetivo_estrategico oe 
			WHERE oe.id_objetivo_estrategico=aoe.id_objetivo_estrategico 
				AND id_anp='".$anp."' AND id_quinquenio='".$quin[id]."'";
		$sql_=new Consulta($sql);
		$array_obj=array();
		while($r_=$sql_->ConsultaVerRegistro()){
			$array_obj[]=$r_[id_anp_objetivo_estrategico];
		}

	
	if($_GET[id_obj]){
		$sql="SELECT * FROM anp_objetivo_estrategico aoe,objetivo_estrategico oe 
			WHERE oe.id_objetivo_estrategico=aoe.id_objetivo_estrategico 
				AND id_anp_objetivo_estrategico='".$_GET[id_obj]."'";
	}else{
		$sql="SELECT * FROM anp_objetivo_estrategico aoe,objetivo_estrategico oe 
			WHERE oe.id_objetivo_estrategico=aoe.id_objetivo_estrategico 
				AND id_anp_objetivo_estrategico='".$array_obj[0]."'";
	}
	$sql=new Consulta($sql);
	$r=$sql->ConsultaVerRegistro();
	//print_r($r);
?>
<table width="537" height="12" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="tab">
<tr><th width="154" >Conceptos</th> 
<th width="381" >Definicion</th>
</tr>
<tr><td><strong>Indicador</strong></td>
<td><?=$r[indicador_objetivo_estrategico]?></td>
</tr>
<tr>
  <td><strong>Unidad de Medida </strong></td>
  <td><?=$r['id_unidad_medida']?></td>
</tr>
<tr>
  <td><strong>Fundamento</strong></td>
  <td><?=$r[fundamento]?></td>
</tr>
<tr>
  <td><strong>Estrategia de Ejecucion </strong></td>
  <td><?=$r[estra_ejecucion]?></td>
</tr>
<tr>
  <td><strong>Forma de Calculo </strong></td>
  <td><?=$r[form_calculo]?></td>
</tr>
<tr>
  <td><strong>Fuente de Informacion </strong></td>
  <td><?=$r[fuen_informacion]?></td>
</tr>
<tr>
  <td><strong>Datos Historicos y Proyeccion </strong></td>
  <td>
  <table width="100%" border="1">
  <tr>
  	<? 
	$axos=explode(',',$quin['axo_poa']);
	foreach($axos as $a){?><td><div align="center"><strong><?=axo($a)?></strong></div></td><? }?>
  </tr>
   <tr>
   	<? foreach($axos as $a){
		$sql_axo=new Consulta("SELECT * FROM anp_objetivo_estrategico_meta 
					WHERE id_anp_objetivo_estrategico='".$r[id_anp_objetivo_estrategico]."' AND id_axo_poa='".$a."'"); 
		$r_axo=$sql_axo->ConsultaVerRegistro();
	?>
   		<td><div align="center"><strong><?=$r_axo[meta_anp_objetivo_estrategico]?></strong></div></td>
	<? }?>
   </tr>
  </table>  </td>
</tr>
<tr>
  <td><strong>Resultados para el 
      <?=axo($_SESSION["inrena_4"][2])?>
  </strong></td>
  <td>
  <? 
  	$sql_m="SELECT id_mes, sum(meta_mes_anp_objetivo_estrategico) as meta FROM anp_objetivo_estrategico AS aoest 
				Inner Join anp_objetivo_estrategico_meta_mes aoem
					ON 	aoem.id_anp_objetivo_estrategico=aoest.id_anp_objetivo_estrategico
				WHERE aoest.id_anp_objetivo_estrategico='".$r[id_anp_objetivo_estrategico]."'
						AND id_axo_poa='".$_SESSION['inrena_4']['2']."' 
				GROUP BY id_mes";
	$query_m=new Consulta($sql_m);
	$array_mes=array();
	while($row_m=$query_m->ConsultaVerRegistro()){
		$array_mes[$row_m[id_mes]]=$row_m[meta];
	} 
	//print_r($array_mes); 
  ?>
  <table width="100%" border="1">
  <tr><td><div align="center"><strong>Trimestre Nº1</strong></div></td>
  <td><div align="center"><strong>Trimestre Nº2</strong></div></td>
  <td><div align="center"><strong>Trimestre Nº3</strong></div></td>
  <td><div align="center"><strong>Trimestre Nº4</strong></div></td>
  </tr>
   <tr><td><?=($array_mes[1]+$array_mes[2]+$array_mes[3])?></td>
   <td><?=($array_mes[4]+$array_mes[5]+$array_mes[6])?></td>
   <td><?=($array_mes[7]+$array_mes[8]+$array_mes[9])?></td>
   <td><?=($array_mes[10]+$array_mes[11]+$array_mes[12])?></td></tr>
  </table>  </td>
</tr>
<tr>
  <td><strong>Tareas necesaria para realizar el Indicador </strong></td>
  <td><table width="100%" border="1">
  	<? 
		$sql_t="Select Sum(afao.monto_asignacion_ff_anp_objetivos) as monto, nombre_tarea, 
					aao.id_asignacion_anp_objetivos, nro_asignacion, id_anp_objetivo_especifico 					
				From asignacion_ff_anp_objetivos AS afao
				Inner Join asignacion_anp_objetivos AS aao
					ON afao.id_asignacion_anp_objetivos = aao.id_asignacion_anp_objetivos
				Inner Join presupuesto_anp AS pa 
					ON afao.id_presupuesto_anp = pa.id_presupuesto_anp
				Inner Join presupuesto_ff AS pf 
					ON pa.id_presupuesto_ff = pf.id_presupuesto_ff
				Inner Join fuente_financiamiento AS ff 
					ON ff.id_ff = pf.id_ff 
				Inner Join tarea AS t 
					ON t.id_tarea=aao.id_tarea
				WHERE aao.id_anp='".$anp."' 
					AND id_anp_objetivo_estrategico='".$r[id_anp_objetivo_estrategico]."'
					AND aao.id_axo_poa='".$_SESSION['inrena_4']['2']."' ".
					permisos_fuente($_SESSION['inrena_4'][1]).	
				" GROUP BY aao.id_asignacion_anp_objetivos
				  ORDER BY id_anp_objetivo_especifico, nro_asignacion"	;  			
			$Query_t=new Consulta($sql_t);	
			$obj_esp=0;
			$array_asig=array();
			while ($row_t = $Query_t->ConsultaVerRegistro()){
				$array_asig[]=$row_t[id_asignacion_anp_objetivos];
				////especificos
				if($obj_sp!=$row_t[id_anp_objetivo_especifico]){
					$obj_sp=$row_t[id_anp_objetivo_especifico];?>
					<tr class='reg1'><td align="left" colspan="3"><b><? 
					$sqq="Select indicador_objetivo_especifico,codigo_objetivo_especifico FROM anp_objetivo_especifico
							WHERE id_anp_objetivo_especifico='".$row_t[id_anp_objetivo_especifico]."'";
					$q=new Consulta($sqq);
					if($rw=$q->ConsultaVerRegistro()){
						$obj_esp=$rw[1];
						echo $r[codigo_objetivo_estrategico].".".$rw[1].". ".$rw[0]; 
					}else echo "!Error en asignacion del Objetivo Estratégico, intente Editar la Asignación¡"?></b></td></tr>
			<? }//fin esp?> 
			<tr>
				<td align="left" ><?=$r[codigo_objetivo_estrategico].".".$obj_esp.".".$row_t[nro_asignacion]."."?></td>
				<td align="left" ><?=$row_t[nombre_tarea];?></td>
				<td align="right">
					<? $programado=Programacion::ProgramacionProgramado('',$row_t[id_asignacion_anp_objetivos],'');
									echo num_format($programado,'.0')?></td>
			</tr>
		<? }?>	
  </table></td>
</tr>
<tr>
  <td><strong>Localizacion</strong></td>
  <td><?=$row_anp[nombre_departamento]?></td>
</tr>
<tr>
  <td rowspan="3"><strong>Aspectos Sociaeconomicos </strong></td>
  <td><u><strong>Beneficiarios directos e inidrectos</strong></u><br>
  <?=$r[bene_dir_ind]?></td>
</tr>
<tr>
  <td><u><strong>Generacion de Empleo </strong></u><br>
<?=$r[gene_empleo]?></td></tr>
<tr>
  <td><u><strong>Alivio a la Pobreza </strong></u><br>
<?=$r[aliv_pobreza]?></td></tr>
<tr>
  <td><strong>Duracion</strong></td>
  <td><? $SQL="SELECT count(*) FROM programacion_metas AS pm
				Inner Join programacion_metas_meses AS pmm ON pm.id_programacion_metas = pmm.id_programacion_metas
				Inner Join asignacion_ff_anp_objetivos AS afao 
					ON afao.id_asignacion_ff_anp_objetivos = pm.id_ff_anp_subactividad
				Inner Join asignacion_anp_objetivos AS aao 
					ON aao.id_asignacion_anp_objetivos = afao.id_asignacion_anp_objetivos
				Inner Join anp_objetivo_especifico AS aoesp 
					ON aoesp.id_anp_objetivo_especifico = aao.id_anp_objetivo_especifico
				Inner Join anp_objetivo_estrategico AS aoet 
					ON aoet.id_anp_objetivo_estrategico = aoesp.id_anp_objetivo_estrategico 
						AND aoet.id_anp_objetivo_estrategico = aao.id_anp_objetivo_estrategico
				WHERE aoet.id_anp_objetivo_estrategico =  '".$r[id_anp_objetivo_estrategico]."'
				GROUP BY pmm.id_mes, aao.id_axo_poa"; 
		$Q_t=new Consulta($SQL);
		$r_t = $Q_t->ConsultaVerRegistro();
		echo $r_t[0]." meses"; 
?></td>
</tr>
<tr>
  <td><strong>Monto Asignado </strong></td>
  <td>
  <?
   $sql="SELECT pa.id_presupuesto_anp, ff.siglas_ff AS 'Fuente/Ejecutor', 
			monto_presupuesto_anp AS Presupuestado, ff.id_ff 
			FROM presupuesto_anp pa, presupuesto_ff pf, fuente_financiamiento ff, 
			fuentefinanciamiento p,fuente_usuario fu 
		WHERE fu.id_usuario='".$_SESSION['inrena_4'][1]."' AND fu.id_ff=ff.id_ff 
				AND fu.id_submodulo='1' AND pf.id_axo_poa='".$_SESSION['inrena_4'][2]."' AND
				pa.id_anp='".$anp."' AND
				pa.id_presupuesto_ff=pf.id_presupuesto_ff AND
				ff.id_ff=pf.id_ff and p.id_fuentefinanciamiento=ff.id_fuentefinanciamiento
			GROUP BY pa.id_presupuesto_anp	
			ORDER BY p.siglas_fuentefinanciamiento, ff.siglas_ff";
	$Query=new Consulta($sql);	
  ?>
  <table width="100%" border="1"><tr>
  <? $tot_programado=0;
  
  while ($row = mysql_fetch_row($Query->Consulta_ID)){?>
  <td><div align="center"><strong><?=$row[1]?></strong></div>
  	<? $sql=" SELECT SUM(monto_programacion_partidas_meses) AS monto
			FROM asignacion_ff_anp_objetivos
				Inner Join programacion_partidas 
			ON asignacion_ff_anp_objetivos.id_asignacion_ff_anp_objetivos = programacion_partidas.id_ff_anp_subactividad
				Inner Join programacion_partidas_meses 
			ON programacion_partidas.id_programacion_partidas = programacion_partidas_meses.id_programacion_partidas
				Inner Join asignacion_anp_objetivos 
			ON asignacion_anp_objetivos.id_asignacion_anp_objetivos = asignacion_ff_anp_objetivos.id_asignacion_anp_objetivos
			WHERE asignacion_anp_objetivos.id_axo_poa =  '".$_SESSION['inrena_4'][2]."' 
				AND asignacion_anp_objetivos.id_anp_objetivo_estrategico = '".$r[id_anp_objetivo_estrategico]."'
				AND asignacion_ff_anp_objetivos.id_presupuesto_anp='".$row[0]."'
			GROUP BY asignacion_ff_anp_objetivos.id_presupuesto_anp";	
			$Qry=new Consulta($sql);
			$rr=$Qry->ConsultaVerRegistro();
			$programado=$rr[monto];	
			$tot_programado+=$programado;
			//$programado=Programacion::ProgramacionProgramado($row[0],0,0);
	?>
	<div align="right"><?=num_format($programado,'.0')?></div></td>
   <? }?>
   <td><div align="center"><strong>Total</strong></div>
   		<div align="right"><?=num_format($tot_programado,'.0')?></div></td>
  </tr></table>  </td>
</tr>
</table>

<div align="center">
<? 	$n=0;
	foreach($array_obj as $id){
		$n++;
		echo '<a href="programacion_nivel_indicador.php?idanp='.$anp.'&id_obj='.$id.'">['.$n.']</a>&nbsp;'; 
	}
?>
</div>
<script language="javascript">
FullScreen();
</script>
</body>
</html>