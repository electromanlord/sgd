<?
require_once("../../includes.php"); 
require_once("../funciones/reportes.php"); 
require("../libs/verificar.inc.php"); 
$link=new Conexion();
set_time_limit(100);

$anp=$_POST['anp'];
if(is_array($_REQUEST[lista_ff])) $ff=implode(',',$_REQUEST[lista_ff]);
else $ff=$_REQUEST[lista_ff];
//print_r($ff);
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

<table width="139%"  border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF">
		  <tr>	
		  <th align='center' class="tit" bgcolor="#999999" >Plan Operativo Institucional&nbsp;<?=axo($_SESSION["inrena_4"][2])?>  </th>  
		  </tr>
		  <tr>
		    <td align="center">Formato Nº 5 - Programacion del Plan Operativo Institucional </td>
		  </tr>
		  <tr>
		    <td align="center">&nbsp;</td>
		  </tr>
</table>
<br>
<table width="100%"  border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
  <tr>
	<td colspan="3"><strong>FTE. FTO.-EJEC. : 
	<?
	$sql="Select siglas_ff FROM fuente_financiamiento WHERE id_ff IN (".$ff.") ORDER BY siglas_ff";
	$Query=new Consulta($sql);	
	while ($row = $Query->ConsultaVerRegistro()){
		echo $row[siglas_ff].",&nbsp;";
	}
	?>
</strong></td>
</tr>
</table>
<table height="12" border="1" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="tab" id='listado'>
<tr>
  	<th rowspan="4" >Indicadores / Tareas </th> 
	<th rowspan="4" >Tipo de Indicador </th>
	<th rowspan="4" >Linea de Base </th>
	<th rowspan="4" >Unidad de Medida </th>
	<th colspan="2" >Programacion <?=axo($_SESSION["inrena_4"][2])?></th>
	<th colspan="24" >Programacion Trimestral</th>
	<th rowspan="4">Numero de Beneficiarios</th>
	<th rowspan="4">Responsable</th>
</tr>
<tr><th rowspan="3">Fisico</th>
<th rowspan="3">Financiero</th>
<th colspan="6">I Trimestre</th><th colspan="6">II Trimestre</th><th colspan="6">III Trimestre</th>
<th colspan="6">IV Trimestre</th></tr>
<tr><th colspan="2">Ene</th><th colspan="2">Feb</th><th colspan="2">Mar</th><th colspan="2">Abr</th>
<th colspan="2">May</th><th colspan="2">Jun</th><th colspan="2">Jul</th><th colspan="2">Ago</th>
<th colspan="2">Sep</th><th colspan="2">Oct</th><th colspan="2">Nov</th><th colspan="2">Dic</th></tr>
<tr>
<th>Fis</th>
<th>Fin</th>
<th>Fis</th>
<th>Fin</th>
<th>Fis</th>
<th>Fin</th>
<th>Fis</th>
<th>Fin</th>
<th>Fis</th>
<th>Fin</th>
<th>Fis</th>
<th>Fin</th>
<th>Fis</th>
<th>Fin</th>
<th>Fis</th>
<th>Fin</th>
<th>Fis</th>
<th>Fin</th>
<th>Fis</th>
<th>Fin</th>
<th>Fis</th>
<th>Fin</th>
<th>Fis</th>
<th>Fin</th>
</tr>
<?
	$array_tot=array('0'=>0,'1'=>0,'2'=>0,'3'=>0,'4'=>0,'5'=>0,'6'=>0,'7'=>0,'8'=>0,'9'=>0,'10'=>0,'11'=>0,'12'=>0);
	
	$sql="SELECT aao.id_anp_objetivo_estrategico, aao.id_anp_objetivo_especifico, id_tarea, 
			aao.id_asignacion_anp_objetivos, nro_asignacion, id_personal_anp
		FROM asignacion_ff_anp_objetivos AS afao
			Inner Join asignacion_anp_objetivos AS aao 
				ON afao.id_asignacion_anp_objetivos = aao.id_asignacion_anp_objetivos
			Inner Join presupuesto_anp AS pa 
				ON afao.id_presupuesto_anp = pa.id_presupuesto_anp
			Inner Join presupuesto_ff AS pf 
				ON pa.id_presupuesto_ff = pf.id_presupuesto_ff
			Inner Join fuente_financiamiento AS ff 
				ON ff.id_ff = pf.id_ff
			Inner Join anp_objetivo_especifico 
				ON anp_objetivo_especifico.id_anp_objetivo_especifico = aao.id_anp_objetivo_especifico
			Inner Join anp_objetivo_estrategico 
			  ON anp_objetivo_estrategico.id_anp_objetivo_estrategico=anp_objetivo_especifico.id_anp_objetivo_estrategico
			Inner Join objetivo_estrategico 
				ON objetivo_estrategico.id_objetivo_estrategico = anp_objetivo_estrategico.id_objetivo_estrategico
		WHERE aao.id_anp='".$anp."' AND aao.id_axo_poa='".$_SESSION['inrena_4']['2']."' ".
			permisos_fuente($_SESSION['inrena_4'][1])." AND pf.id_ff IN (".$ff.") ".
		" GROUP BY aao.id_asignacion_anp_objetivos 
		ORDER BY codigo_objetivo_estrategico, codigo_objetivo_especifico,nro_asignacion";	
		
	$from_financ="SELECT sum(programacion_partidas_meses.monto_programacion_partidas_meses) AS monto 
		FROM programacion_partidas_meses
			Inner Join programacion_partidas 
		ON programacion_partidas_meses.id_programacion_partidas = programacion_partidas.id_programacion_partidas
			Inner Join asignacion_ff_anp_objetivos 
		ON asignacion_ff_anp_objetivos.id_asignacion_ff_anp_objetivos = programacion_partidas.id_ff_anp_subactividad
			Inner Join asignacion_anp_objetivos 
		ON asignacion_anp_objetivos.id_asignacion_anp_objetivos = asignacion_ff_anp_objetivos.id_asignacion_anp_objetivos
			Inner Join presupuesto_anp 
		ON presupuesto_anp.id_presupuesto_anp = asignacion_ff_anp_objetivos.id_presupuesto_anp
			Inner Join presupuesto_ff 
		ON presupuesto_ff.id_presupuesto_ff = presupuesto_anp.id_presupuesto_ff
			Inner Join fuente_financiamiento 
		ON fuente_financiamiento.id_ff = presupuesto_ff.id_ff 
		WHERE fuente_financiamiento.id_ff IN (".$ff.") ".
			permisos_fuente($_SESSION['inrena_4'][1],'fuente_financiamiento').
			" 	AND asignacion_anp_objetivos.id_anp='".$anp."' 
				AND asignacion_anp_objetivos .id_axo_poa='".$_SESSION['inrena_4']['2']."' ";
	
	$from_fisico="SELECT sum(metas_meses.cantidad_metas_meses) AS monto FROM asignacion_ff_anp_objetivos
			Inner Join asignacion_anp_objetivos 
		ON asignacion_anp_objetivos.id_asignacion_anp_objetivos = asignacion_ff_anp_objetivos.id_asignacion_anp_objetivos
			Inner Join presupuesto_anp 
		ON presupuesto_anp.id_presupuesto_anp = asignacion_ff_anp_objetivos.id_presupuesto_anp
			Inner Join presupuesto_ff 
		ON presupuesto_ff.id_presupuesto_ff = presupuesto_anp.id_presupuesto_ff
			Inner Join fuente_financiamiento 
		ON fuente_financiamiento.id_ff = presupuesto_ff.id_ff
			Inner Join metas_meses 
		ON asignacion_ff_anp_objetivos.id_asignacion_ff_anp_objetivos = metas_meses.id_ff_anp_subactividad 
		WHERE fuente_financiamiento.id_ff IN (".$ff.") ".
			permisos_fuente($_SESSION['inrena_4'][1],'fuente_financiamiento').
			" 	AND asignacion_anp_objetivos.id_anp='".$anp."' 
				AND asignacion_anp_objetivos .id_axo_poa='".$_SESSION['inrena_4']['2']."' ";
							
	$Query=new Consulta($sql);
	$obj=0; $obj_sp=0; 
	while ($row = $Query->ConsultaVerRegistro()){
		///obj estrat
		if($obj!=$row[id_anp_objetivo_estrategico]){ 
			$obj=$row[id_anp_objetivo_estrategico];?>
			<tr class='reg2'>
			<td align="left" nowrap ><strong>Indicador General <? 
			$sq="Select *	FROM objetivo_estrategico oe, 
					anp_objetivo_estrategico aoe
				WHERE aoe.id_objetivo_estrategico=oe.id_objetivo_estrategico 
						AND id_anp_objetivo_estrategico='".$row[id_anp_objetivo_estrategico]."'";
			$q=new Consulta($sq);
			$rw=$q->ConsultaVerRegistro();
			$obj_cod=$rw[codigo_objetivo_estrategico];
			echo $rw[codigo_objetivo_estrategico].": ".$rw[indicador_objetivo_estrategico]; ?></strong></td>
			<td>Resultado</td>
			<td>0</td>
			<td><?=$rw[id_unidad_medida]?></td>
			 <? 
				$sql_m="SELECT id_mes, sum(meta_mes_anp_objetivo_estrategico) as meta 
							FROM anp_objetivo_estrategico AS aoest 
							Inner Join anp_objetivo_estrategico_meta_mes aoem
								ON 	aoem.id_anp_objetivo_estrategico=aoest.id_anp_objetivo_estrategico
							WHERE aoest.id_anp_objetivo_estrategico='".$row[id_anp_objetivo_estrategico]."'
									AND id_axo_poa='".$_SESSION['inrena_4']['2']."' 
							GROUP BY id_mes";
				$query_m=new Consulta($sql_m);
				$array_mes=array();
				while($row_m=$query_m->ConsultaVerRegistro()){
					$array_mes[$row_m[id_mes]]=$row_m[meta];
				} 
				//print_r($array_mes); 
			  ?>
			
			<td>
			  <div align="right">
			   <?=array_sum($array_mes)?>
		      </div></td>
			<td>
			  <div align="right">
			    <? 	$sql_fin=$from_financ." AND id_anp_objetivo_estrategico='".$row[id_anp_objetivo_estrategico]."' ";
				$qf=new Consulta($sql_fin);
				$rwf=$qf->ConsultaVerRegistro();
				echo num_format($rwf[monto])."&nbsp;";
			?>
		      </div></td>
			<? for($i=1;$i<13;$i++){?>
				<td>
				  <div align="right">
				    <?=$array_mes[$i]?>
		        </div></td>
				<td>
				  <div align="right">
				    <? 	$sql_fin=$from_financ." AND id_anp_objetivo_estrategico='".$row[id_anp_objetivo_estrategico]."' 
						AND id_mes='".$i."'";
					$qf=new Consulta($sql_fin);
					$rwf=$qf->ConsultaVerRegistro();
					echo num_format($rwf[monto]);
			?>
		        </div></td>
			<? }?>
			<td><?=$rw[bene_dir_ind]?></td>
			<td>&nbsp;</td>
			</tr>
		<? }
		
		////objet espec
		if($obj_sp!=$row[id_anp_objetivo_especifico]){
				$obj_sp=$row[id_anp_objetivo_especifico];?>
			<tr class='reg1'>
			<td align="left" nowrap>Indicador Específico&nbsp;<? 
				$sqq="Select * FROM anp_objetivo_especifico
							WHERE id_anp_objetivo_especifico='".$row[id_anp_objetivo_especifico]."'";
				$qo=new Consulta($sqq);
				if($rlw=$qo->ConsultaVerRegistro()){
				 	$obj_esp=$rlw[codigo_objetivo_especifico];
					echo $rlw[codigo_objetivo_especifico].": ".$rlw[indicador_objetivo_especifico]; 
				}?>			</td>
			<td>Producto</td>
			<td>0</td>
			<td><?=$rlw[unidad_medida]?></td>
			<? 
				$sql_m="SELECT id_mes, sum(meta_mes_anp_objetivo_especifico) as meta 
							FROM anp_objetivo_especifico_meta_mes 
							WHERE id_anp_objetivo_especifico='".$row[id_anp_objetivo_especifico]."'
									AND id_axo_poa='".$_SESSION['inrena_4']['2']."' 
							GROUP BY id_mes";
				$query_m=new Consulta($sql_m);
				$array_mes_sp=array();
				while($row_m=$query_m->ConsultaVerRegistro()){
					$array_mes_sp[$row_m[id_mes]]=$row_m[meta];
				} 
				//print_r($array_mes); 
			  ?>
			<td>
			  <div align="right">
			   <?=array_sum($array_mes_sp)?>
		      </div></td>
			<td>
			  <div align="right">
			    <? 	$sql_fin=$from_financ." AND id_anp_objetivo_estrategico='".$obj."' 
					AND id_anp_objetivo_especifico='".$row[id_anp_objetivo_especifico]."'";
				$qf=new Consulta($sql_fin);
				$rwf=$qf->ConsultaVerRegistro();
				echo num_format($rwf[monto])."&nbsp;";
			?>
		      </div></td>
			<? for($i=1;$i<13;$i++){?>
				<td>
				  <div align="right">
				 <?=$array_mes_sp[$i]?>
		        </div></td>
				<td>
				  <div align="right">
				    <? 	$sql_fin=$from_financ." AND id_anp_objetivo_estrategico='".$obj."' 
						AND id_anp_objetivo_especifico='".$row[id_anp_objetivo_especifico]."' AND id_mes='".$i."'";
					$qf=new Consulta($sql_fin);
					$rwf=$qf->ConsultaVerRegistro();
					echo num_format($rwf[monto])."&nbsp;";
			?>
		        </div></td>
			<? }?>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			</tr>
		<? }
		////tareas
		$sqql="Select nombre_tarea,medio_verificacion_tarea From tarea WHERE id_tarea='".$row[id_tarea]."'";
		$Qt=new Consulta($sqql);
		$rowt=$Qt->ConsultaVerRegistro();
		?> 
		<tr>
		<td align="left" nowrap >&nbsp;&nbsp;
			Tarea&nbsp;<? echo $row[nro_asignacion].": ".$rowt[nombre_tarea]?></td>
		<td>&nbsp;</td>	<td>&nbsp;</td>	<td>
		  <div align="center">
		    <?=$rowt[medio_verificacion_tarea]?>
	      </div></td>	
		<td>
			<div align="right">
			  <? 	$sql_fis=$from_fisico." AND id_anp_objetivo_estrategico='".$row[id_anp_objetivo_estrategico]."' 
					AND id_anp_objetivo_especifico='".$row[id_anp_objetivo_especifico]."'
					AND id_tarea='".$row[id_tarea]."'";
				$qx=new Consulta($sql_fis);
				$rwx=$qx->ConsultaVerRegistro();
				echo $rwx[monto]."&nbsp;";
			?>
		  </div></td>
			<td>
			  <div align="right">
			    <? 	$sql_fin=$from_financ." AND id_anp_objetivo_estrategico='".$row[id_anp_objetivo_estrategico]."' 
					AND id_anp_objetivo_especifico='".$row[id_anp_objetivo_especifico]."' 
					AND id_tarea='".$row[id_tarea]."'";
				$qf=new Consulta($sql_fin);
				$rwf=$qf->ConsultaVerRegistro();
				echo num_format($rwf[monto]);
				
				$array_tot[0]+=$rwf[monto]."&nbsp;";///total
			?>
	        </div></td>
			<? for($i=1;$i<13;$i++){?>
				<td>
				  <div align="right">
				    <? 	$sql_fis=$from_fisico." AND id_anp_objetivo_estrategico='".$row[id_anp_objetivo_estrategico]."' 
						AND id_anp_objetivo_especifico='".$row[id_anp_objetivo_especifico]."' 
						AND id_tarea='".$row[id_tarea]."'AND id_mes='".$i."'";
					$qx=new Consulta($sql_fis);
					$rwx=$qx->ConsultaVerRegistro();
					echo $rwx[monto]."&nbsp;";
				?>
		        </div></td>
				<td>
				  <div align="right">
				    <? 	$sql_fin=$from_financ." AND id_anp_objetivo_estrategico='".$row[id_anp_objetivo_estrategico]."' 
						AND id_anp_objetivo_especifico='".$row[id_anp_objetivo_especifico]."' 
						AND id_tarea='".$row[id_tarea]."'AND id_mes='".$i."'";
					$qf=new Consulta($sql_fin);
					$rwf=$qf->ConsultaVerRegistro();
					echo num_format($rwf[monto])."&nbsp;";
					$array_tot[$i]+=$rwf[monto];///total
			?>
		        </div></td>
			<? }?>
		<td>&nbsp;</td><td>
		<? 	$sper="Select * FROM personal_anp where id_personal_anp='".$row[id_personal_anp]."'";
			$Qper=new Consulta($sper); 
			$rper=$Qper->ConsultaVerRegistro();
			echo $rper[2]." ".$rper[3];
		?>
		</td>
		</tr>
	
<? }?>
<tr>
<th>Total</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
<? foreach($array_tot as $tot){?>
	<td><div align="right">&nbsp;</div></td><td><div align="right">
	  <?=num_format($tot)."&nbsp;"?>
	  </div></td>
<? }?>
<td><div align="right"></div></td><td><div align="right"></div></td>
</tr>
</table>


<script language="javascript">
FullScreen();
</script>
</body>
</html>